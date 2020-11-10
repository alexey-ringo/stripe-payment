<?php

namespace Tests\Feature\Payments;

use App\Billing\BillingGateway;
use App\Billing\FakeBillingGateway;
use App\Http\Livewire\Payments\ProcessPayment;
use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;


class ProcessPaymentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_successfully_processes_a_payment()
    {
        $fakeBillingGateway = new FakeBillingGateway();
        $this->instance(BillingGateway::class, $fakeBillingGateway);

        $payment = Payment::factory()->create([
            'status' => PaymentStatus::NEW,
            'amount' => 1200
        ]);

        $testable = Livewire::test(ProcessPayment::class, ['payment' => $payment])
            ->set('billingToken', $fakeBillingGateway->generateValidPaymentToken())
            ->call('process');

        $this->assertEquals(1200, $fakeBillingGateway->getTotalChargesAmount());
        $this->assertEquals(1, $fakeBillingGateway->charges()->count());
        $this->assertEquals($fakeBillingGateway->lastCharge()->getBillingId(), $payment->fresh()->billing_charge_id);
        $this->assertEquals(PaymentStatus::PAID, $payment->fresh()->status);
    }
}
