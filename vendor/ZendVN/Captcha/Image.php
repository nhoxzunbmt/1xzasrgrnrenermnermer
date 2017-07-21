<?php
namespace ZendVN\Captcha;

use Zend\Captcha\Image as ZendImage;

class Image extends ZendImage{
        protected $imgDir;
        protected $imgUrl;
        protected $imgAlt               = "Captcha";
        protected $suffix               = ".png";
        protected $width                = 150;
        protected $height               = 50;
        protected $fsize                = 25;
        protected $wordlen              = 5;
        protected $font;
        protected $expiration           = 20;
        protected $dotNoiseLevel        = 100;
        protected $lineNoiseLevel       = 5;
        public function __construct($width = 150, $height = 50,$options = null){
        	$this->font             = !empty($options['font']) ? $options['font'] : CAPTCHA_PATH .'/fonts/times.ttf';
                $this->imgDir           = CAPTCHA_PATH .'/images';
                $this->imgUrl           = CAPTCHA_URL .'/images';      
                $this->fsize            = !empty($options['fsize']) ? $options['fsize'] : $this->fsize;
                $this->wordlen          = !empty($options['wordlen']) ? $options['wordlen'] : $this->wordlen;
                $this->width            = !empty($width) ? $width : $this->width;
                $this->height           = !empty($height) ? $height : $this->height;
                $this->dotNoiseLevel    = !empty($options['dotNoiseLevel']) ? $options['dotNoiseLevel'] : $this->dotNoiseLevel;
                $this->lineNoiseLevel   = !empty($options['lineNoiseLevel']) ? $options['lineNoiseLevel'] : $this->lineNoiseLevel;
                $this->suffix           = !empty($options['suffix']) ? $options['suffix'] : $this->suffix;
                $this->expiration       = !empty($options['expiration']) ? $options['expiration'] : $this->expiration;
                

                //Thiết lập đường dẫn tới thư mục hình ảnh chưa captcha
                $this->setImgDir($this->imgDir);
                //thiết lập đường dẫn tới thư mục chứa captcha
                $this->setImgUrl($this->imgUrl);
                //thiết lập font chữ
                $this->setFont($this->font);
                //thiết lập kích thước font chữ
                $this->setFontSize($this->fsize);
                //Thiết lập chiều dài của chuỗi
                $this->setWordlen($this->wordlen);
                //Thiết lập kích thước hình ảnh
                $this->setWidth($this->width);
                $this->setHeight($this->height);
                //Thiết lập số dấu chấm
                $this->setDotNoiseLevel($this->dotNoiseLevel);
                //Thiết lập số đường line trong captcha
                $this->setLineNoiseLevel($this->lineNoiseLevel);
                //Thiết lập phần mở rộng
                $this->setSuffix($this->suffix);
                //Thời gian tồn tại của hình
                $this->setExpiration($this->expiration);
                //phát sinh captcha
                $this->generate();
        }

        public function remove($captchaID, $options = null){
                if($options == null){
                        $imgLink = $this->getImgDir() .$captchaID.$this->getSuffix();
                        @unlink($imgLink);   
                }
                
        }
}