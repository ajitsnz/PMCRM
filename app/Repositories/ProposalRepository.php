<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Lead;
use App\Models\PaymentMode;
use App\Models\Proposal;
use App\Models\ProposalAddress;
use App\Models\SalesItem;
use App\Models\Tag;
use App\Models\TaxRate;
use App\Models\User;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ProposalRepository
 * @package App\Repositories
 * @version April 8, 2020, 11:32 am UTC
 */
class ProposalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'proposal_number',
        'title',
        'related',
        'date',
        'open_till',
        'currency',
        'discount_type',
        'status',
        'user_id',
        'phone',
        'unit',
        'total_amount',
        'sub_total',
        'discount',
        'adjustment',
        'payment_status',
    ];

    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * @var EstimateRepository
     */
    private $estimateRepository;

    public function __construct(
        Application $app,
        InvoiceRepository $invoiceRepository,
        EstimateRepository $estimateRepository
    ) {
        parent::__construct($app);
        $this->invoiceRepository = $invoiceRepository;
        $this->estimateRepository = $estimateRepository;
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
        return Proposal::class;
    }

    /**
     * @param  null  $customerId
     *
     * @return mixed
     */
    function getProposalsStatusCount($customerId = null)
    {
        if (! empty($customerId)) {
            return Proposal::selectRaw('count(case when status = 1 then 1 end) as drafted')
                ->selectRaw('count(case when status = 2 then 1 end) as open')
                ->selectRaw('count(case when status = 3 then 1 end) as revised')
                ->selectRaw('count(case when status = 4 then 1 end) as declined')
                ->selectRaw('count(case when status = 5 then 1 end) as accepted')
                ->selectRaw('count(case when status != 1 then 1 end) as total_proposals')
                ->where('owner_type', '=', Customer::class)->where('owner_id', '=', $customerId)->first();
        }

        return Proposal::selectRaw('count(case when status = 1 then 1 end) as drafted')
            ->selectRaw('count(case when status = 2 then 1 end) as open')
            ->selectRaw('count(case when status = 3 then 1 end) as revised')
            ->selectRaw('count(case when status = 4 then 1 end) as declined')
            ->selectRaw('count(case when status = 5 then 1 end) as accepted')
            ->selectRaw('count(*) as total_proposals')
            ->first();
    }

    /**
     * @return mixed
     */
    public function getSyncList()
    {
        $data['tags'] = Tag::pluck('name', 'id')->toArray();
        $data['users'] = User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id')->toArray();
        $data['related'] = Proposal::RELATED_TO_array;
        $data['leads'] = Lead::pluck('name', 'id')->toArray();
        $data['customers'] = Customer::pluck('company_name', 'id')->toArray();
        $data['status'] = Proposal::STATUS;
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
     * @return Proposal
     */
    public function saveProposal($input)
    {
        /** @var Proposal $proposal */

        if (isset($input['related_to']) && isset($input['owner_id'])) {
            $input['owner_type'] = Proposal::RELATED_TO[$input['related_to']];
        }

        $input['phone'] = preparePhoneNumber($input, 'phone');

        $proposal = $this->create($this->prepareProposalData($input));
        $ownerType = $proposal->getOwnerType();

        activity()->performedOn($proposal)->causedBy(getLoggedInUser())
            ->useLog('New Proposal created.')->log($proposal->title.' Proposal created.');

        if (isset($input['tags']) && ! empty($input['tags'])) {
            $proposal->tags()->sync($input['tags']);
        }

        // Store Address
        $this->addProposalAddresses($input, $proposal);
        // Store Items
        $this->invoiceRepository->storeSalesItems($input, $proposal);
        // Store Applied Taxes with Amount
        $this->invoiceRepository->storeSalesTaxes($input, $proposal);

        return $proposal;
    }

    /**
     * @param  array  $input
     *
     * @return array
     */
    public function prepareProposalData($input)
    {
        $proposalFields = (new Proposal())->getFillable();
        $items = [];

        foreach ($input as $key => $value) {
            if (in_array($key, $proposalFields)) {
                $items[$key] = $value;
            }
        }

        $items['total_amount'] = formatNumber($input['total_amount']);
        $items['discount'] = formatNumber($input['final_discount']);
        $items['sub_total'] = formatNumber($input['sub_total']);
        $items['payment_status'] = 1;

        return $items;
    }

    /**
     * @param  array  $input
     *
     * @param $proposal
     *
     * @return bool|void
     */
    public function addProposalAddresses($input, $proposal)
    {
        if (! isset($input['street'])) {
            return;
        }
        ProposalAddress::create([
            'street'      => (isset($input['street'])) ? $input['street'] : null,
            'city'        => (isset($input['city'])) ? $input['city'] : null,
            'state'       => (isset($input['state'])) ? $input['state'] : null,
            'zip_code'    => (isset($input['zip_code'])) ? $input['zip_code'] : null,
            'country'     => (isset($input['country'])) ? $input['country'] : null,
            'type'        => 1,
            'proposal_id' => $proposal->id,
        ]);

        return true;
    }

    /**
     * @param  int  $id
     *
     * @return Proposal
     */
    public function getProposalData($id)
    {
        /** @var Proposal $proposal */
        $proposal = Proposal::with([
            'tags', 'proposalAddresses', 'salesItems',
        ])->find($id);

        return $proposal;
    }


    /**
     * @param  int  $id
     *
     * @return Builder[]|Collection
     */
    public function getProposalItems($id)
    {
        $proposal = Proposal::find($id);

        $proposalItems = SalesItem::where('owner_id', '=', $proposal->getId())->where('owner_type', '=',
            $proposal->getOwnerType())->get();

        return $proposalItems;
    }

    /**
     * @param  array  $input
     *
     * @param  int  $id
     *
     * @return Proposal
     */
    public function updateProposal($input, $id)
    {
        /** @var Proposal $proposal */
        $proposal = Proposal::find($id);

        if (isset($input['related_to']) && isset($input['owner_id'])) {
            $input['owner_type'] = Proposal::RELATED_TO[$input['related_to']];
        }

        $input['phone'] = preparePhoneNumber($input, 'phone');

        $proposal->update($this->prepareProposalData($input));

        activity()->performedOn($proposal)->causedBy(getLoggedInUser())
            ->useLog('Proposal updated.')->log($proposal->title.' Proposal updated.');

        if (! isset($input['tags']) && empty($input['tags'])) {
            $input['tags'] = null;
        }

        $proposal->tags()->sync($input['tags']);

        $proposal->proposalAddresses()->delete();
        $this->addProposalAddresses($input, $proposal);

        // Store Items
        $this->invoiceRepository->storeSalesItems($input, $proposal);
        // Store Applied Taxes with Amount
        $this->invoiceRepository->storeSalesTaxes($input, $proposal);

        return $proposal;
    }

    /**
     * @param $input
     *
     * @return array
     */
    public function prepareSalesItemData($input)
    {
        $items = [];
        if (isset($input['item']) && ! empty($input['item'])) {
            foreach ($input as $key => $data) {
                foreach ($data as $index => $value) {
                    $items[$index][$key] = $value;
                }
            }

            return $items;
        }
    }

    /**
     * @param $proposal
     */
    public function deleteProposal($proposal)
    {
        activity()->performedOn($proposal)->causedBy(getLoggedInUser())
            ->useLog('Proposal deleted.')->log($proposal->title.' Proposal deleted.');

        $proposal->tags()->detach();
        $proposal->proposalAddresses()->delete();
        $proposal->salesItems()->delete();
        $proposal->salesTaxes()->delete();
        $proposal->delete();
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function getSyncListForProposalDetail($id)
    {
        /** @var Proposal $proposal */
        $proposal = Proposal::with([
            'user', 'salesItems.taxes', 'proposalAddresses', 'salesTaxes',
        ])->find($id);

        return $proposal;
    }

    /**
     * @param  int  $id
     *
     * @param $status
     *
     * @return int
     */
    public function changeProposalStatus($id, $status)
    {
        return Proposal::whereId($id)->update(['status' => $status]);
    }

    /**
     * @param  Proposal  $proposal
     *
     * @return Invoice
     */
    public function convertToInvoice($proposal)
    {
        try {
            $data['customer_id'] = $proposal->owner_id;
            $data['title'] = $proposal->title;
            $data['sales_agent_id'] = $proposal->assigned_user_id;
            $data['discount_type'] = $proposal->discount_type;
            $data['invoice_number'] = Invoice::generateUniqueInvoiceId();
            $data['invoice_date'] = $proposal->date;
            $data['due_date'] = $proposal->open_till;
            $data['currency'] = $proposal->currency;
            $data['unit'] = $proposal->unit;
            $data['adjustment'] = $proposal->adjustment;
            $data['final_discount'] = $proposal->discount;
            $data['sub_total'] = $proposal->sub_total;
            $data['total_amount'] = $proposal->total_amount;
            $data['payment_status'] = Invoice::STATUS_UNPAID;
            $data['payment_modes'] = PaymentMode::whereActive(true)->pluck('id')->toArray();
            $data['tags'] = $proposal->tags->pluck('id')->toArray();
            $data['taxes'] = [];

            foreach ($proposal->salesItems as $key => $record) {
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

    /**
     * @param  Proposal  $proposal
     *
     * @return Estimate
     */
    public function convertToEstimate($proposal)
    {
        try {
            $data['customer_id'] = $proposal->owner_id;
            $data['title'] = $proposal->title;
            $data['sales_agent_id'] = $proposal->assigned_user_id;
            $data['discount_type'] = $proposal->discount_type;
            $data['estimate_number'] = Estimate::generateUniqueEstimateId();
            $data['estimate_date'] = $proposal->date;
            $data['estimate_expiry_date'] = $proposal->open_till;
            $data['currency'] = $proposal->currency;
            $data['unit'] = $proposal->unit;
            $data['final_discount'] = $proposal->discount;
            $data['adjustment'] = $proposal->adjustment;
            $data['sub_total'] = $proposal->sub_total;
            $data['total_amount'] = $proposal->total_amount;
            $data['status'] = Estimate::STATUS_SEND;
            $data['tags'] = $proposal->tags->pluck('id')->toArray();
            $data['taxes'] = [];

            foreach ($proposal->salesItems as $record) {
                $itemArr['item'] = $record['item'];
                $itemArr['description'] = $record['description'];
                $itemArr['quantity'] = $record['quantity'];
                $itemArr['rate'] = formatNumber($record['rate']);
                $itemArr['total'] = formatNumber($record['total']);
                $data['itemsArr'][] = $itemArr;
            }

            $estimate = $this->estimateRepository->store($data);

            return $estimate;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
