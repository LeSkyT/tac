<?php

class BgCreate {

  private $textures;

  private $matrixWidth;
  private $matrixHeight;
  private $imageMatrix = array();

  private $image;

  private $texture_dim = 64;

  const RESSOURCES_PATH = "/home/a-ct/server/www/public/img/textures/";
  const DST_PATH = "/home/a-ct/server/www/public/img/bg/";
  const EXPORT_PATH = "/img/bg/";

  public function __construct($width, $height) {
    $this->getRessources();
    $this->matrixWidth = ceil($width / $this->texture_dim);
    $this->matrixHeight = ceil($height / $this->texture_dim);

    $this->createImageMatrix();

    $this->createImage();
  }

  public function getImage() {
    return $this->image;
  }

  public function saveImg() {
    
    $basename = $this->matrixWidth . "x" . $this->matrixHeight;
    $filename = $basename . ".png";

    $path = BgCreate::DST_PATH . $filename;
    $url = BgCreate::EXPORT_PATH . $filename;

    imagepng($this->image, $path);

    return $url;
  }

  private function getRandX() {
    return mt_rand(0, $this->matrixWidth - 1);
  }

  private function getRandY() {
    return mt_rand(0, $this->matrixHeight - 1);
  }


  private function getRessources() {
    $textureFiles = scandir(BgCreate::RESSOURCES_PATH);
    foreach($textureFiles as $file) {
      $path = BgCreate::RESSOURCES_PATH . $file;
      if (!is_dir($path) && $file != "." && $file != "..")
      $this->addTexture($path);
    }
  }

  private function addTexture($path) {
    $orig = imagecreatefrompng($path);

    $texture = imagecreatetruecolor($this->texture_dim, $this->texture_dim);

    imagecopyresized($texture, $orig, 0, 0, 0, 0, $this->texture_dim, $this->texture_dim, 512, 512);

    $name = pathinfo($path, PATHINFO_FILENAME);

    $this->textures[$name] = $texture;
  }

  private function createImageMatrix() {
    for ($i = 0; $i < $this->matrixWidth; $i++){
      for ($j = 0; $j < $this->matrixHeight; $j++){
	$this->imageMatrix[$i][$j] = "stone";
      }
    }

    $this->addVeins(0, 70, "andesite", 5, 10);

    $this->addVeins(4, 65, "coal", 10, 8);
    $this->addVeins(4, 65, "iron", 6, 8);
    $this->addVeins(4, 30, "gold", 1, 6);
    $this->addVeins(4, 15, "redstone", 8, 6);
    $this->addVeins(4, 30, "lapis", 1, 6);
    $this->addVeins(4, 15, "diamond", 1, 6);
  }

  private function addVeins($miny, $maxy, $ore, $luck, $spread) {
    $max = round(($this->matrixHeight - 1) - (($this->matrixHeight - 1) * $miny / 70));
    $min = round(($this->matrixHeight - 1) - (($this->matrixHeight - 1) * $maxy / 70));

    error_log("creating veins for " . $ore . " (" . $min . "=>" . $max . ")");
    for($y = $min; $y <= $max; $y++){
      if ($luck >= mt_rand(0, 10)) {
	$this->addVariant($this->getRandX(), $y, $ore, $spread);
      }
    }
  }

  private function addVariant($x, $y, $type, $chance = 0){
    if(0 > $x || $this->matrixWidth <= $x)
      return false;

    if(0 > $y || $this->matrixHeight <= $y)
      return false;

    if($this->imageMatrix[$x][$y] == $type)
      return false;

    if(! array_key_exists($type, $this->textures))
      throw new Execption("ressource: \"" . $type ."\" is not registered.");

    $this->imageMatrix[$x][$y] = $type;

    //spread mekanism.
    if($chance >= mt_rand(0, 10))
      $this->addVariant(mt_rand($x - 1, $x + 1), mt_rand($y - 1, $y + 1), $type, $chance - 1);
  }

  private function createImage() {
    $height = $this->texture_dim * $this->matrixHeight;
    $width = $this->texture_dim * $this->matrixWidth;

    $this->image = imagecreatetruecolor($width, $height);
    
    for ($i = 0; $i < $this->matrixWidth; $i++){
      for ($j = 0; $j < $this->matrixHeight; $j++){
	$x = $i * $this->texture_dim;
	$y = $j * $this->texture_dim;
	imagecopy($this->image, $this->textures[$this->imageMatrix[$i][$j]], $x, $y, 0, 0, $this->texture_dim, $this->texture_dim);
      }
    }
  }
}
