<?php


namespace Turing\Payment\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use League\Fractal\Resource\Item as ResourceItem;
use Stripe\Charge;
use Stripe\Stripe;
use Turing\Backend\Repository\AbstractPaginator;
use Turing\Backend\Repository\RepositoryInterface;

/**
 * Class StripeRepository
 * @package Turing\Payment\Repository
 */
class StripeRepository implements RepositoryInterface
{

    /**
     * @var Stripe
     */
    private $gateway;
    /**
     * @var Charge
     */
    private $charge;

    public function __construct(Stripe $gateway, Charge $charge)
    {
        $this->gateway = $gateway;
        $this->gateway->setApiKey(env('STRIPE_SECRET'));
        $this->charge = $charge;
    }

    public function createCardToken(Collection $data)
    {
        $stripeToken = \Stripe\Token::create([
            'card' => $data->only('number', 'exp_month', 'exp_year', 'cvc')->toArray()
        ]);

        return ['stripeToken' => $stripeToken['id']];
    }

    public function processPayment(Collection $data)
    {
        return $this->charge->create($data->only("amount", "currency", "source", "description")->toArray());
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return ResourceItem
     */
    public function item(int $id, Collection $filters = null): Model
    {
        // TODO: Implement item() method.
    }

    /**
     * @param Collection|null $filters
     * @return AbstractPaginator
     */
    public function collection(Collection $filters = null): Paginator
    {
        // TODO: Implement collection() method.
    }

    /**
     * @param Collection $data
     * @return Model
     */
    public function add(Collection $data): Model
    {
        // TODO: Implement add() method.
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function update(int $id, Collection $data): Model
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
