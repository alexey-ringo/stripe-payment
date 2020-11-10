<?php

namespace App\Http\Livewire\Payments;

use App\Billing\BillingGateway;
use Livewire\Component;
use App\Models\Payment;
use App\Models\PaymentStatus;

class ProcessPayment extends Component
{
    /**
     * @var Payment|mixed
     */
    public $payment;

    /**
     * @var string
     */
    public $billingToken;

    public function mount(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function process(BillingGateway $billingGateway)
    {
        $charge = $billingGateway->charge($this->payment->amount, $this->billingToken);

        $this->payment->update([
            'status' => PaymentStatus::PAID,
            'billing_charge_id' => $charge->getBillingId()
        ]);
    }

    public function render()
    {
        return view('livewire.payments.process-payment');
    }
}
