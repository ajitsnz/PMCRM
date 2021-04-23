<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateAddress;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\PaymentMode;
use App\Models\Tag;
use App\Models\TaxRate;
use App\Models\User;
use Exception;
use Illuminate\Container\Container as Application;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class EstimateRepository
 * @package App\Repositories
 * @version April 27, 2020, 6:16 am UTC
 */
class EstimateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'status',
        'currency',
        'estimate_number',
        'reference',
        'sales_agent_id',
        'discount_type',
        'estimate_date',
        'estimate_expiry_date',
        'admin_note',
        'discount',
    ];

    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    public function __construct(Application $app, InvoiceRepository $invoiceRepository)
    {
        parent::__construct($app);
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Estimate::class;
    }

    /**
     * @param  null  $customerId
     *
     * @return mixed
     */
    function getEstimatesStatusCount($customerId = null)
    {
        if (! empty($customerId)) {
            return Estimate::selectRaw('count(case when status = 0 then 1 end) as drafted')
                ->selectRaw('count(case when status = 1 then 1 end) as sent')
                ->selectRaw('count(case when status = 2 then 1 end) as expired')
                ->selectRaw('count(case when status = 3 then 1 end) as declined')
                ->selectRaw('count(case when status = 4 then 1 end) as accepted')
                ->selectRaw('count(case when status != 0 then 1 end) as total_estimates')
                ->where('customer_id', '=', $customerId)->first();
        }

        return Estimate::selectRaw('count(case when status = 0 then 1 end) as drafted')
            ->selectRaw('count(case when status = 1 then 1 end) as sent')
            ->selectRaw('count(case when status = 2 then 1 end) as expired')
            ->selectRaw('count(case when status = 3 then 1 end) as declined')
            ->selectRaw('count(case when status = 4 then 1 end) as accepted')
            ->selectRaw('count(*) as total_estimates')
            ->first();
    }

    /**
     * @return mixed
     */
    public function getSyncList()
    {
        $data['customers'] = Customer::pluck('company_name', 'id')->toArray();
        $data['tags'] = Tag::pluck('name', 'id')->toArray();
        $data['saleAgents'] = User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id')->toArray();
        $data['discountType'] = Estimate::DISCOUNT_TYPES;
        $data['status'] = Estimate::STATUS;
        $data['currencies'] = Customer::CURRENCIES;
        $taxRates = TaxRate::get();
        $data['taxes'] = $taxRates;
        $data['taxesArr'] = $taxRates->pluck('tax_rate', 'id')->toArray();
        $data['items'] = Item::pluck('title', 'id')->toArray();

        return $data;
    }

    /**
     * @param  array  $input
     *
     * @return Estimate
     */
    public function store($input)
    {
        /** @var Estimate $estimate */
        $estimate = $this->create($this->prepareEstimateData($input));

        activity()->performedOn($estimate)->causedBy(getLoggedInUser())
            ->useLog('New Estimate created.')->log($estimate->title.' Estimate created.');

        if (isset($input['tags']) && ! empty($input['tags'])) {
            $estimate->tags()->sync($input['tags']);
        }
        // Store Address
        $this->addEstimateAddresses($input, $estimate);
        // Store Items
        $this->invoiceRepository->storeSalesItems($input, $estimate);
        // Store Applied Taxes with Amount
        $this->invoiceRepository->storeSalesTaxes($input, $estimate);

        return $estimate;
    }

    /**
     * @param  array  $input
     *
     * @return array
     */
    public function prepareEstimateData($input)
    {
        $estimateFields = (new Estimate())->getFillable();
        $items = [];

        foreach ($input as $key => $value) {
            if (in_array($key, $estimateFields)) {
                $items[$key] = $value;
            }
        }

        $items['total_amount'] = formatNumber($input['total_amount']);
        $items['discount'] = formatNumber($input['final_discount']);
        $items['sub_total'] = formatNumber($input['sub_total']);

        return $items;
    }

    /**
     * @param  array  $input
     *
     * @param  Estimate  $estimate
     *
     * @return bool|void
     */
    public function addEstimateAddresses($input, $estimate)
    {
        for ($i = 0; $i <= 2; $i++) {
            if (! isset($input['street'][$i])) {
                return;
            }

            EstimateAddress::create([
                'street'      => (isset($input['street'][$i])) ? $input['street'][$i] : null,
                'city'        => (isset($input['city'][$i])) ? $input['city'][$i] : null,
                'state'       => (isset($input['state'][$i])) ? $input['state'][$i] : null,
                'zip_code'    => (isset($input['zip_code'][$i])) ? $input['zip_code'][$i] : null,
                'country'     => (isset($input['country'][$i])) ? $input['country'][$i] : null,
                'type'        => $i + 1,
                'estimate_id' => $estimate->id,
            ]);
        }

        return true;
    }

    /**
     * @param  array  $input
     *
     * @param  Estimate  $estimate
     *
     * @return Estimate
     */
    public function update($input, $estimate)
    {
        $estimate->update($this->prepareEstimateData($input));

        activity()->performedOn($estimate)->causedBy(getLoggedInUser())
            ->useLog('Estimate updated.')->log($estimate->title.' Estimate updated.');

        if (isset($input['tags']) && ! empty($input['tags'])) {
            $estimate->tags()->sync($input['tags']);
        }

        $estimate->estimateAddresses()->delete();
        $this->addEstimateAddresses($input, $estimate);

        // Update Items
        $this->invoiceRepository->storeSalesItems($input, $estimate);
        // Update Applied Taxes with Amount
        $this->invoiceRepository->storeSalesTaxes($input, $estimate);

        return $estimate;
    }

    /**
     * @param  Estimate  $estimate
     *
     * @throws Exception
     */
    public function deleteEstimate($estimate)
    {
        activity()->performedOn($estimate)->causedBy(getLoggedInUser())
            ->useLog('Estimate deleted.')->log($estimate->title.' Estimate deleted.');

        $estimate->tags()->detach();
        $estimate->estimateAddresses()->delete();
        $estimate->salesItems()->delete();
        $estimate->salesTaxes()->delete();
        $estimate->delete();
    }

    /**
     * @param  int  $id
     *
     * @param $status
     *
     * @return bool|int
     */
    public function changeEstimateStatus($id, $status)
    {
        return Estimate::whereId($id)->update(['status' => $status]);
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function getSyncForEstimateDetail($id)
    {
        $estimate = Estimate::with([
            'customer', 'user', 'tags', 'salesItems.taxes', 'salesTaxes', 'estimateAddresses',
        ])->find($id);

        return $estimate;
    }

    /**
     * @param  int  $id
     *
     * @param $status
     *
     * @return bool|int
     */
    public function changeStatus($id, $status)
    {
        return Estimate::whereId($id)->update(['status' => $status]);
    }

    /**
     * @param  Estimate  $estimate
     *
     * @return Invoice
     */
    public function convertToInvoice($estimate)
    {
        try {
            $data['title'] = $estimate->title;
            $data['customer_id'] = $estimate->customer_id;
            $data['sales_agent_id'] = $estimate->sales_agent_id;
            $data['discount_type'] = $estimate->discount_type;
            $data['invoice_number'] = Invoice::generateUniqueInvoiceId();
            $data['invoice_date'] = $estimate->estimate_date;
            $data['due_date'] = $estimate->estimate_expiry_date;
            $data['currency'] = $estimate->currency;
            $data['unit'] = $estimate->unit;
            $data['adjustment'] = $estimate->adjustment;
            $data['final_discount'] = $estimate->discount;
            $data['sub_total'] = $estimate->sub_total;
            $data['total_amount'] = $estimate->total_amount;
            $data['payment_status'] = Invoice::STATUS_UNPAID;
            $data['payment_modes'] = PaymentMode::whereActive(true)->pluck('id')->toArray();
            $data['tags'] = $estimate->tags->pluck('id')->toArray();
            $data['taxes'] = [];

            foreach ($estimate->salesItems as $key => $record) {
                $itemArr['item'] = $record['item'];
                $itemArr['description'] = $record['description'];
                $itemArr['quantity'] = $record['quantity'];
                $itemArr['rate'] = formatNumber($record['rate']);
                $itemArr['total'] = formatNumber($record['total']);
                $data['itemsArr'][] = $itemArr;
            }

            $invoice = $this->invoiceRepository->saveInvoice($data);

            return $invoice;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
