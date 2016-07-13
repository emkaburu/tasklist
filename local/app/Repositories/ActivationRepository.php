<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Connection;

class ActivationRepository {
	protected $db;
	protected $table = 'user_activations';

	public function __construct(Connection $db){
		//when we init a new Activation, we pass it a connection to use so we have to set this instance's connection
		$this->db = $db;
	}

	protected function getToken(){
		return hash_hmac('sha256', str_random(5), config('app.key'));
	}


	public function createActivation($user){
		$activation = $this->getActivation($user);

		//if we don't have an existing activation token, we create a new one and return, else we regenerate
		if(!$activation){
			return $this->createToken($user);
		}

		return $this->regenerateToken($user);

	}

	/**
	 * Regenerate the token and insert
	 *
	 */
	private function regenerateToken($user){
		$token = $this->getToken();
		$this->db->table($this->table)->where('user_id', $user->id)
			->update([
				'token' => $token,
				'created_at' => new Carbon()
			]);

			return $token;
	}

	/**
	 * Create token and insert into the DB
	 *
	 */
	private function createToken($user){
		$token = $this->getToken();

		$this->db->table($this->table)
			->insert([
					'user_id' => $user->id,
					'token'   => $token,
					'created_at' => new Carbon()
				]);			
		
		return $token;
	}

	/**
	 *
	 *
	 */
	public function getActivation($user){
		return $this->db->table($this->table)->where('user_id', $user->id)->first();
	}



	/**
	 *
	 *
	 */
	public function getActivationByToken($token){
		return $this->db->table($this->table)->where('token', $token)->first();
	}


	/**
	 *
	 *
	 */
	public function deleteActivation($token){
		$this->db->table($this->table)->where('token', $token)->delete();
	}

}//end class