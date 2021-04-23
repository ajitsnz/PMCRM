<?php

namespace App\Repositories;

use App\Models\CreditNote;
use App\Models\CreditNoteAddress;
use App\Models\Customer;
use App\Models\Item;
use App\Models\TaxRate;
use Exception;
use Illuminate\Container\Container as Application;

/**
 * Class InvoiceRepository
 * @package App\Repositories
 * @version April 8, 2020, 11:32 am UTC
 */
class CreditNoteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',
        'title',
        'bill_to',
        'ship_to',
        'credit_note_number',
        'credit_note_date',
        'currency',
        'discount_type',
        'admin_text',
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
        return CreditNote::class;
    }

    /**
     * @return mixed
     */
    function getStatusCount()
    {
        return CreditNote::selectRaw('count(case when payment_status = 0 then 1 end) as drafted')
            ->selectRaw('count(case when payment_status = 1 then 1 end) as open')
            ->selectRaw('count(case when payment_status = 2 then 1 end) as void')
            ->selectRaw('count(case when payment_status = 3 then 1 end) as closed')
            ->first();
    }

    /**
     * @return mixed
     */
    public function getSyncList()
    {
        $data['customers'] = Customer::pluck('company_name', 'id')->toArray();
        $data['discountType'] = $this->getDiscountTypes();
        $data['currencies'] = Customer::CURRENCIES;
        $taxRates = TaxRate::get();
        $data['taxes'] = $taxRates;
        $data['taxesArr'] = $taxRates->pluck('tax_rate', 'id')->toArray();
        $data['items'] = Item::pluck('title', 'id')->toArray();

        return $data;
    }

    /**
     * @return array
     */
    public function getDiscountTypes()
    {
        return $discountType = [
            '0' => 'No Discount',
            '1' => 'Before Tax',
            '2' => 'After Tax',
        ];
    }

    /**
     * @param  array  $input
     *
     * @return CreditNote
     */
    public function saveCreditNote($input)
    {
        /** @var CreditNote $creditNote */
        $creditNote = $this->create($this->prepareCreditNoteData($input));

        activity()->performedOn($creditNote)->causedBy(getLoggedInUser())
            ->useLog('New Credit Note created.')->log($creditNote->title.' Credit Note created.');

        // Store Address
        $this->addCreditNoteAddresses($input, $creditNote);
        // Store Items
        $this->invoiceRepository->storeSalesItems($input, $creditNote);
        // Store Applied Taxes with Amount
        $this->invoiceRepository->storeSalesTaxes($input, $creditNote);

        return $creditNote;
    }

    /**
     * @param  array  $input
     *
     * @return array
     */
    public function prepareCreditNoteData($input)
    {
        $creditNoteFields = (new CreditNote())->getFillable();
        $items = [];

        foreach ($input as $key => $value) {
            if (in_array($key, $creditNoteFields)) {
                $items[$key] = $value;
            }
        }

        $items['total_amount'] = formatNumber($input['total_amount']);
        $items['discount'] = formatNumber($input['final_discount']);
        $items['sub_total'] = formatNumber($input['sub_total']);
        $items['payment_status'] = $input['payment_status'];

        return $items;
    }

    /**
     * @param  array  $input
     *
     * @param $creditNote
     *
     * @return bool|void
     */
    public function addCreditNoteAddresses($input, $creditNote)
    {
        for ($i = 0; $i <= 2; $i++) {
            if (! isset($input['street'][$i])) {
                return;
            }

            CreditNoteAddress::create([
                'street'         => (isset($input['street'][$i])) ? $input['street'][$i] : null,
                'city'           => (isset($input['city'][$i])) ? $input['city'][$i] : null,
                'state'          => (isset($input['state'][$i])) ? $input['state'][$i] : null,
                'zip_code'       => (isset($input['zip_code'][$i])) ? $input['zip_code'][$i] : null,
                'country'        => (isset($input['country'][$i])) ? $input['country'][$i] : null,
                'type'           => $i + 1,
                'credit_note_id' => $creditNote->id,
            ]);
        }

        return true;
    }

    /**
     * @param  array  $input
     *
     * @param  int  $id
     *
     * @return CreditNote
     */
    public function updateCreditNote($input, $id)
    {
        /** @var CreditNote $creditNote */
        $creditNote = CreditNote::find($id);
        $creditNote->update($this->prepareCreditNoteData($input));

        activity()->performedOn($creditNote)->causedBy(getLoggedInUser())
            ->useLog('Credit Note updated.')->log($creditNote->title.' Credit Note updated.');

        $creditNote->creditNoteAddresses()->delete();
        $this->addCreditNoteAddresses($input, $creditNote);

        // Update Items
        $this->invoiceRepository->storeSalesItems($input, $creditNote);
        // Update Applied Taxes with Amount
        $this->invoiceRepository->storeSalesTaxes($input, $creditNote);

        return $creditNote;
    }

    /**
     * @param  CreditNote  $creditNote
     *
     * @throws Exception
     */
    public function deleteCreditNote($creditNote)
    {
        activity()->performedOn($creditNote)->causedBy(getLoggedInUser())
            ->useLog('Credit Note deleted.')->log($creditNote->title.' Credit Note deleted.');

        $creditNote->creditNoteAddresses()->delete();
        $creditNote->salesItems()->delete();
        $creditNote->salesTaxes()->delete();
        $creditNote->delete();
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function getSyncListForCreditNoteDetail($id)
    {
        $creditNote = CreditNote::with([
            'customer', 'salesItems.taxes', 'creditNoteAddresses', 'salesTaxes',
        ])->find($id);

        return $creditNote;
    }

    /**
     * @param  int  $id
     *
     * @param $paymentStatus
     *
     * @return int
     */
    public function changePaymentStatus($id, $paymentStatus)
    {
        return CreditNote::whereId($id)->update(['payment_status' => $paymentStatus]);
    }
}
