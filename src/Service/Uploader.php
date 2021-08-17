<?php

namespace App\Service;

use App\Entity\Photos;

class Uploader
{
    public static function upload_actu($file, $dis, $actu, $manager)
    {

        $filename = Uploader::uniquename($file->getClientOriginalName());
        move_uploaded_file($file->getPathname(), $dis . '/' . $filename);

        $image = new Photos();
        $image->setActu($actu);
        $image->setSrc($filename);
        $manager->persist($image);
        $manager->flush();
    }

    public static function upload_machine($file, $dis, $machine, $manager)
    {
        
        $filename = Uploader::uniquename($file->getClientOriginalName());
        move_uploaded_file($file->getPathname(), $dis . '/' . $filename);

        $image = new Photos();
        $image->setMachines($machine);
        $image->setSrc($filename);
        $manager->persist($image);
        $manager->flush();
    }

    public static function upload_album($file, $dis, $album, $manager)
    {
    
        $filename = Uploader::uniquename($file->getClientOriginalName());
        move_uploaded_file($file->getPathname(), $dis . '/' . $filename);

        $image = new Photos();
        $image->setAlbum($album);
        $image->setSrc($filename);
        $manager->persist($image);
        $manager->flush();
    }

    public static function upload_formation($file, $dis, $formation, $manager)
    {
    
        $filename = Uploader::uniquename($file->getClientOriginalName());
        move_uploaded_file($file->getPathname(), $dis . '/' . $filename);

        $image = new Photos();
        $image->setFormation($formation);
        $image->setSrc($filename);
        $manager->persist($image);
        $manager->flush();
    }

    public static function upload_annonce($file, $dis, $annonce, $manager)
    {
    
        $filename = Uploader::uniquename($file->getClientOriginalName());
        move_uploaded_file($file->getPathname(), $dis . '/' . $filename);

        $image = new Photos();
        $image->setAnnonce($annonce);
        $image->setSrc($filename);
        $manager->persist($image);
        $manager->flush();
    }
    
    private static function uniquename($filename)
    {
        $ext = explode('.', $filename)[1];
        return uniqid() . '.' . $ext;
    }
}


