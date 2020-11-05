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
    
    public function render()
    {
        return view('livewire.contact-form');
    }

    public function submitForm()
    {
        $contact = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        Mail::to(config('mail.recipient.support'))->send(
            new ContactFormMailable($contact)
        );

        $this->reset();
        
        $this->successMessage = 'Email sent successfully.';
    }
}
