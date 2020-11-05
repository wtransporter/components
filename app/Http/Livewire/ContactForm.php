<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Mail\ContactFormMailable;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{
    public $successMessage = '';
    public $name;
    public $email;
    public $phone;
    public $message;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'message' => 'required|min:5',
    ];
    
    /**
     * Live validation. Checks while typing
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }

    /**
     * Form submit and send email
     */
    public function submitForm()
    {
        $contact = $this->validate();

        Mail::to(config('mail.recipient.support'))->send(
            new ContactFormMailable($contact)
        );

        $this->reset();

        $this->successMessage = 'Email sent successfully.';
    }
}
