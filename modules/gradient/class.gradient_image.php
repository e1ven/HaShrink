<?php
/**
 * Cria uma imagem com um gradiente a partir de duas cores em
 * notação hexadecimal, utilizando um número definido de etapas.
 *
 * Baseada na classe Gradient de Michael Feinbier, disponível em:
 * http://sliphacker.friends.phpclasses.org/browse/package/1410.html
 *
 *   Este programa é software livre; você pode redistribuí-lo e/ou
 *   modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a versão 2 da
 *   Licença como (a seu critério) qualquer versão mais nova.
 *
 *   Este programa é distribuído na expectativa de ser útil, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *   COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *   PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *   detalhes.
 *
 *   Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *   junto com este programa; se não, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *
 * @package Classe Gradient_Image
 * @author Fabricio Biazzotto <sliphacker.nospam@yahoo.com.br>
 * @copyright Copyright © 2004
 * @version 1.0
 * @access public
 **/

class gradient_image {
    var $from;
    var $to;
    var $steps;
    var $width;
    var $height;

    /**
     * gradient_image::gradient_image() - Contrutor da classe
     *
     * @param $from Cor inicial em notação hexadecimal
     * @param $to Cor final em notação hexadecimal
     * @param $steps Número de etapas do gradiente
     * @param $width Largura da imagem
     * @param $height Altura da imagem
     **/
    function gradient_image($from, $to, $steps, $width, $height)
    {
        $this->from   = $this->getHexValues($from);
        $this->to     = $this->getHexValues($to);
        $this->steps  = $steps;
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * gradient_image::getHexValues() - Cria um array com valores RGB a partir de uma cor em formato hexadecimal
     *
     * @param $color Cor em formato hexadecimal a ser convertida
     * @return array Array com os valores RGB em formato decimal
	 * @access private
     **/
    function getHexValues($color)
    {
        $color = substr($color, -6);
        return array(hexdec(substr($color, 0, 2)), hexdec(substr($color, 2, 2)), hexdec(substr($color, 4, 2)));
    }

    /**
     * gradient_image::createArray() - Cria um array com as cores do gradiente
     *
     * @return array Array com as cores do gradiente
     **/
    function createArray()
    {
        $red   = ($this->to[0] - $this->from[0]) / ($this->steps-1);
        $green = ($this->to[1] - $this->from[1]) / ($this->steps-1);
        $blue  = ($this->to[2] - $this->from[2]) / ($this->steps-1);

        for($i = 0; $i < $this->steps; $i++) {
            $newred   = $this->from[0] + round($i * $red);
            $newgreen = $this->from[1] + round($i * $green);
            $newblue  = $this->from[2] + round($i * $blue);
            $return[$i] = array($newred, $newgreen, $newblue);
        }

        return $return;
    }

    /**
     * gradient_image::createImage() - Cria uma imagem
     *
     * @param boolean $vertical Define se o gradiente será criado no sentido vertical
     * @return resource Recurso da imagem criada
     **/
    function createImage($vertical = false)
    {
        if ($vertical) {
          if ($this->steps > $this->width)  $this->steps = $this->width;
        } else {
          if ($this->steps > $this->height) $this->steps = $this->height;
        }

        $im = imagecreatetruecolor($this->width, $this->height);
        $gradient = $this->createArray();

        foreach ($gradient as $color) {
            $red   = $color[0];
            $green = $color[1];
            $blue  = $color[2];
            $colors[] = imagecolorallocate($im, $red, $green, $blue);
        }

        if ($vertical) {
            $step = $this->width / $this->steps;
            $y = $this->height;
            if ($step == 1)
                for ($x = 0, $i = 0; $x < $this->width; $x += $step, $i++)
                  imageline($im, $x, 0, $x, $y, $colors[$i]);
            else
                for ($x = 0, $i = 0; $x < $this->width; $x += $step, $i++)
                  imagefilledrectangle($im, $x, 0, $x + $step, $y, $colors[$i]);
        } else {
            $step = $this->height / $this->steps;
            $x = $this->width;
            if ($step == 1)
                for ($y = 0, $i = 0; $y < $this->height; $y += $step, $i++)
                    imageline($im, 0, $y, $x, $y, $colors[$i]);
            else
                for ($y = 0, $i = 0; $y < $this->height; $y += $step, $i++)
                    imagefilledrectangle($im, 0, $y, $x, $y + $step, $colors[$i]);
        }

        return $im;
    }

    /**
     * gradient_image::createPNG() - Cria uma imagem em formato PNG a partir do recurso de imagem especificado
     *
     * @param boolean $im Recurso de imagem a ser utilizado
     * @param boolean $interlaced Define se a imagem será entrelaçada
     * @return null
     **/
    function createPNG($im = false, $interlaced = false)
    {
        $imagevariable = "";
        if (!$im) $im = $this->createImage();
        if ($interlaced) imageinterlace ($im, 1);
        //header("Content-type: " . image_type_to_mime_type(IMAGETYPE_PNG));
        ob_start();
        imagepng($im);
        $imagevariable = ob_get_contents();
        imagedestroy($im);
        ob_end_clean();

        return $imagevariable;
    }

    /**
     * gradient_image::createJPEG() - Cria uma imagem em formato JPEG a partir do recurso de imagem especificado
     *
     * @param resource $im Recurso de imagem a ser utilizado
     * @param boolean $progressive Define se a imagem será progressiva
     * @param integer $quality Define a qualidade da imagem
     * @return null
     **/
    function createJPEG($im = false, $progressive = false, $quality = 75)
    {
        if (!$im) $im = $this->createImage();
        if ($progressive) imageinterlace ($im, 1);
        header("Content-type: " . image_type_to_mime_type(IMAGETYPE_JPEG));
        imagejpeg($im, '', $quality);
        imagedestroy($im);
    }
}

?>