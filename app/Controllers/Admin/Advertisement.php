<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdvertisementModel;


class Advertisement extends BaseController
{
	public function index()
	{
		$data['title'] = "Advertisement";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $advertisementModel = new AdvertisementModel();
        $data['advertisement'] = $advertisementModel->getImage();

        // echo "<pre>"; print_r($data); die();
        
        echo view('admin/advertisement/index', $data);  
        echo view('admin/common/footer', $data);
	}

    public function upload()
    {
        $file = $this->request->getFile('advertisementfile');

        // Check file validity
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $file->getErrorString()
            ]);
        }

        // Validate file
        $validationRule = [
            'advertisementfile' => [
                'label' => 'Image File',
                'rules' => 'uploaded[advertisementfile]'
                    . '|is_image[advertisementfile]'
                    . '|mime_in[advertisementfile,image/jpg,image/jpeg,image/png,image/gif,image/webp]'
                    . '|max_size[advertisementfile,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => implode(", ", $this->validator->getErrors())
            ]);
        }

        // Move file
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'uploads/advertisement/', $newName);

            // Save to DB
            $advertisementModel = new AdvertisementModel();
            $advertisementModel->updateImage($newName);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Image uploaded successfully.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'File upload failed.'
        ]);
    }

    public function delete()
    {
        $advertisementModel = new AdvertisementModel();
        $advertisementModel->deleteImage();

        return redirect()->to('/admin/advertisement')->with('success', 'Advertisement deleted successfully.');
    }

}