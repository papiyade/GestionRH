<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidatureAccuse extends Mailable
{
    use Queueable, SerializesModels;

    public $prenom;
    public $nom;
    public $jobOfferTitle;

    /**
     * Create a new message instance.
     */
    public function __construct($prenom, $nom, $jobOfferTitle)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->jobOfferTitle = $jobOfferTitle;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Accusé de réception de votre candidature')
                    ->view('emails.candidature_accuse');
    }
}
