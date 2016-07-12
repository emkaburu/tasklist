<?php

namespace App;


use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;
use App\Repositories\ActivationRepository;

use Illuminate\Routing\UrlGenerator;

class ActivationService{
	
	protected $mailer;
	protected $activationRepo;
	protected $resendAfter = 24;

	public function __construct(Mailer $mailer, ActivationRepository $activationRepo){
		$this->mailer = $mailer;
		$this->activationRepo = $activationRepo;
	}

	/**
	 * On registration we invoke this
	 * Or when you try to log in 24 hrs after we sent the first link
	 */
	public function sendActivationMail($user){

		// if user is already activated, don't go farther
		if($user->activated || !$this->shouldSend($user)){
			return;
		}

		$uname = "";
		if($user->firstname == "" && $user->lastname == ""){
			$uname = "Task Manager User";
		}else{
			$uname = $user->firstname. " " .$user->lastname;
		}

		$token = $this->activationRepo->createActivation($user);
		$link = route('user.activate', ['token' => $token]);
		$message = sprintf('Activate Account <a href="%s"> HERE </a>', $link);

		 Mail::send('emails.acc_activation', ['user_name' => $uname, 'link'=> $link], function ($m) use ($user) {
            $m->from('eric.m.kaburu@gmail.com', 'Task Manager');

            $m->to($user->email, $user->name)->subject('Task Manager Account Activation');
        });

	}//end sendActivationMail


	/**
	 * User is sent here when they click the link on they email.
	 *
	 */
	public function activateuser($token){

		//here we get an instance of ActivationRepository
		$activation = $this->activationRepo->getActivationByToken($token);

		//If we don't have the token in our tokens table, exit
		if($activation === null){
			return null;
		}

		//get the user we dealing with here
		$user = User::find($activation->user_id);

		$user->activated = true;

		$user->save();

		$this->activationRepo->deleteActivation($token);
		
		return $user;
	}

	/**
	 *
	 *
	 */
	public function shouldSend($user){
		$activation = $this->activationRepo->getActivation($user);
		return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
	}

}//End class