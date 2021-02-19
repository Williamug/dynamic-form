<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class Contacts extends Component
{
	public $contacts, $name, $phone, $contact_id;
	public $updateMode = false;
	public $inputs = [];
	public $i = 1;

	public function add($i)
	{
		$i = $i + 1;
		$this->i = $i;
		array_push($this->inputs, $i);
	}

	public function remove($i)
	{
		unset($this->inputs[$i]);
	}

	private function clearForm()
	{
		$this->name = '';
		$this->phone = '';
	}

	public function store()
	{
		$validatedData = $this->validate([
			'name.0' => 'required',
			'phone.0' => 'required',
			'name.*' => 'required',
			'phone.*' => 'required',
		],
		[
			'name.0.required' => 'name field is required',

                'phone.0.required' => 'phone field is required',

                'name.*.required' => 'name field is required',

                'phone.*.required' => 'phone field is required',
		]);

		foreach ($this->name as $key => $value) {
			Contact::create([
				'name' => $this->name[$key], 
				'phone' => $this->phone[$key],
			]);
		}

		$this->inputs = [];
		$this->clearForm();

		session()->flash('message', 'Contact has been created succussfully');
	}

    public function render()
    {
    	$this->contacts = Contact::all();

        return view('livewire.contacts');
    }
}
