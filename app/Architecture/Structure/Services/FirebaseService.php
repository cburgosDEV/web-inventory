<?php

namespace App\Architecture\Structure\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Storage;
use Kreait\Firebase\Contract\Auth;

class FirebaseService
{
    protected $storage;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount('../resources/credentials/firebase_credentials.json');

        $this->storage = $factory->createStorage();
    }

    public function storeImage($image_base64, $folderName)
    {
        //Decodificar la imagen base64 y guardarla en un archivo temporal
        $image_parts = explode(";base64,", $image_base64);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . $image_type;
        file_put_contents($tempFilePath, $image_base64);

        //Ruta en Firebase Storage donde se guardará la imagen
        $file = $folderName . uniqid() . '.' . $image_type;

        //Obtener el cubo (bucket) de Firebase Storage
        $bucket = $this->storage->getBucket();

        //Subir la imagen a Firebase Storage
        $bucket->upload(
            file_get_contents($tempFilePath),
            ['name' => $file]
        );

        //Eliminar el archivo temporal
        unlink($tempFilePath);

        return $file;
    }

    public function getImage($file) {
        $bucket = $this->storage->getBucket();

        return $bucket->object($file)->signedUrl(new \DateTime('+1 hour'));
    }

    public function deleteImage($file) {
        $this->storage->getBucket()->object($file)->delete();
    }
}
