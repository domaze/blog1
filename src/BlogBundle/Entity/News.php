<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// N'oubliez pas ce use :
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
* @ORM\Entity
* @ORM\Table{name="bl_news"}
* @ORM\HasLifecycleCallbacks
*/
class News {

/**
 * @var int
 *
 * @ORM\Column(name="id", type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="AUTO")
 */
  private $id;

/**
 * @var \DateTime
 *
 * @ORM\Column(name="date", type="datetime")
 */
private $date;

/**
* @ORM\Column{name="content", type="text"}
*/
protected $content;

/**
* @ORM\Column{name="title", type="string", length=255}
*/
protected $title;

/**
* @ORM\Column{name="image", type="string", length=255}
*/
protected $image;

/**
* @ORM\Column{name="alt", type="string", length=255, nullable="true"}
*/
protected $alt;

// /**
// *@ORM\Column{name="published", type="boolean"}
// *
// */
// protected $published;

public function __construct() {
  $this->date = new \Datetime();
}

public function getId(){
  return $this->id;
}

/**
 * @param \DateTime $date
 */
public function setDate($date)
{
  $this->date = $date;
}

/**
 * @return \DateTime
 */
public function getDate()
{
  return $this->date;
}

public function setContent($content){
  $this->content = $content;
}

public function getContent(){
  return $this->content;
}

public function setTitle($title){
  $this->title = $title;
}

public function getTitle(){
  return $this->title;
}

public function setImage($image){
  $this->image = $image;
}

public function getImage() {
  return $this->image;
}

public function setAlt($alt){
  $this->alt = $alt;
}

public function getAlt() {
  return $this->alt;
}

// public function setPublished($published){
//   $this->alt = $published;
// }
//
// public function getPublished() {
//   return $this->published;
// }


}
