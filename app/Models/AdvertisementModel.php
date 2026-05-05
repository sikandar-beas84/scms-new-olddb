<?php
namespace App\Models;
use CodeIgniter\Model;

class AdvertisementModel extends Model
{

    protected $table      = 'advertisement';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'file_name', 
        'uploaded_at', 
        'uploaded_by',

    ]; 

	public function getImage()
	{
	    return $this->orderBy('id', 'DESC')->first();
	}

	public function updateImage($file_name, $user_id='')
	{
	    $existing = $this->first();

	    $user_id = !empty($user_id) ? $user_id : session()->get('user_id');

	    if ($existing) {
	        // delete old file
	        if (!empty($existing['file_name']) && file_exists(FCPATH . 'uploads/advertisement/' . $existing['file_name'])) {
	            unlink(FCPATH . 'uploads/advertisement/' . $existing['file_name']);
	        }

	        // update
	        return $this->update($existing['id'], [
	            'file_name' => $file_name,
	            'uploaded_by' => $user_id
	        ]);
	    } else {
	        // insert
	        return $this->insert([
	            'file_name' => $file_name,
	            'uploaded_by' => $user_id
	        ]);
	    }
	}

	public function deleteImage()
	{
	    $image = $this->first();

	    if ($image) {
	        // delete file
	        $filePath = FCPATH . 'uploads/advertisement/' . $image['file_name'];

	        if (!empty($image['file_name']) && file_exists($filePath)) {
	            unlink($filePath);
	        }

	        // delete DB record
	        return $this->delete($image['id']);
	    }

	    return false;
	}
}

