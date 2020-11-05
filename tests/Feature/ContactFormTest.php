<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Mail\ContactFormMailable;
use App\Http\Livewire\ContactForm;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactFormTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_main_page_contains_contact_form_livewire_component()
    {
        $this->get('/')
            ->assertSeeLivewire('contact-form');
    }

    /** @test */
    public function contact_form_sends_out_an_email()
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'Test')
            ->set('email', 'john@test.com')
            ->set('phone', '123456')
            ->set('message', 'This is form message')
            ->call('submitForm')
            ->assertSee('Email sent successfully.');

        Mail::assertSent(function (ContactFormMailable $mail) {
            $mail->build();

            return $mail->hasTo(config('mail.recipient.support')) && 
                $mail->hasFrom('john@test.com') &&
                $mail->subject == 'Mail from Contact form';
        });
    }

    /** @test */
    public function contact_form_name_field_is_required()
    {
        Livewire::test(ContactForm::class)
            ->set('email', 'john@test.com')
            ->set('phone', '123456')
            ->set('message', 'This is form message')
            ->call('submitForm')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function contact_form_message_has_minimum_characters_limit()
    {
        Livewire::test(ContactForm::class)
            ->set('message', 'asd')
            ->call('submitForm')
            ->assertHasErrors(['message' => 'min']);
    }
}
