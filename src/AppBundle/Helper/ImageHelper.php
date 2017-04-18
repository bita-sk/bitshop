<?php

namespace AppBundle\Helper;

/**
 * Class ImageHelper
 *
 * @package AppBundle\Helper
 */
class ImageHelper
{


    /**
     * @param $savePath
     * @param $productId
     */
    public function saveImageFromInput($savePath, $productId)
    {
        $valid_formats = array("jpg", "png", "gif", "zip", "bmp");
        $max_file_size = 1024 * 8000; //100 kb
        $path = $savePath . "/bundles/images/product_images/" . $productId . "/"; // Upload directory

        if (!file_exists($path)) {
            mkdir($path, "0777", true);
        }

        $count = 0;
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            // Loop $_FILES to exeicute all files
            foreach ($_FILES['files']['name'] as $f => $name) {
                if ($_FILES['files']['error'][$f] == 4) {
                    continue; // Skip file if any error found
                }
                if ($_FILES['files']['error'][$f] == 0) {
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                        $message[] = "$name is too large!.";
                        continue; // Skip large files
                    } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                        $message[] = "$name is not a valid format";
                        continue; // Skip invalid file formats
                    } else { // No error found! Move uploaded files
                        $temp = explode(".", $_FILES["files"]["name"][$f]);
                        $newFilename = $count . '.' . end($temp);

                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . $newFilename))
                            $count++; // Number of successfully uploaded file
                    }
                }
            }
        }
    }

}