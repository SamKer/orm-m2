<?php
/**
 * Ce fichier est développé pour la gestion de la lib MCE
 * 
 * Cette Librairie permet d'accèder aux données sans avoir à implémenter de couche SQL
 * Des objets génériques vont permettre d'accèder et de mettre à jour les données
 * 
 * ORM Mél Copyright © 2020 Groupe Messagerie/MTES
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace LibMelanie\Api\Defaut;

use LibMelanie\Lib\MceObject;
use LibMelanie\Objects\UserMelanie;
use LibMelanie\Log\M2Log;

/**
 * Classe objet partagé LDAP par defaut
 * 
 * @author Groupe Messagerie/MTES - Apitech
 * @package LibMCE
 * @subpackage API/Defaut
 * @api
 * 
 * @property string $uid Identifiant unique de l'utilisateur
 * @property string $fullname Nom complet de l'utilisateur
 * @property string $email_send Adresse email d'émission principale de l'utilisateur
 * @property array $email_send_list Liste de toutes les adresses email d'émission de l'utilisateur
 * @property-read User $mailbox Récupère la boite mail associé à l'objet de partage
 * @property-read string $user_uid L'uid de l'utilisateur de l'objet de partage
 * @property-read string $mailbox_uid L'uid la boite possédant l'objet de partage
 * @property-read string $delimiter Le delimiter utilisé pour reconnaitre les objets de partages
 */
abstract class ObjectShare extends MceObject {
  /**
   * Délimiteur de l'objet de partage
   * 
   * @var string
   */
  const DELIMITER = '';

  /**
   * Boite associée à l'objet de partage
   * 
   * @var User
   */
  protected $_mailbox;

  /**
   * UID de l'utilisateur accédant à l'objet de partage
   * 
   * @var string
   */
  protected $_user_uid;

  /**
   * UID de la boite possedant l'objet de partage
   * 
   * @var string
   */
  protected $_mailbox_uid;

  /**
   * Nom de la conf serveur utilisé pour le LDAP
   * 
   * @var string
   */
  protected $_server;

  /**
   * Liste des propriétés à sérialiser pour le cache
   */
  protected $serializedProperties = [
    '_mailbox',
    '_user_uid',
    '_mailbox_uid',
    '_server',
  ];

  /**
   * Constructeur de l'objet
   */
  public function __construct($server = null) {
    // Défini la classe courante
    $this->get_class = get_class($this);
    
    M2Log::Log(M2Log::LEVEL_DEBUG, $this->get_class . "->__construct()");
    // Définition de l'utilisateur
    $this->objectmelanie = new UserMelanie($server);
    // Gestion d'un second serveur d'annuaire dans le cas ou les informations sont répartis
    if (isset(\LibMelanie\Config\Ldap::$OTHER_LDAP)) {
      $this->otherldapobject = new UserMelanie(\LibMelanie\Config\Ldap::$OTHER_LDAP);
    }
    $this->_server = $server;
    $classUser = $this->__getNamespace() . '\\User';
    // Mise en place du mapping
    if (!empty($classUser::MAPPING)) {
      foreach (\LibMelanie\Config\Ldap::$SERVERS as $key => $_server) {
        \LibMelanie\Config\Ldap::$SERVERS[$key]['mapping'] = isset($_server['mapping']) ? \array_merge($classUser::MAPPING, $_server['mapping']) : $classUser::MAPPING;
      }
    }
  }

  /**
   * Retourne la boite mail associée à l'objet de partage
   * 
   * @return User
   */
  protected function getMapMailbox() {
    M2Log::Log(M2Log::LEVEL_DEBUG, $this->get_class . "->getMapMailbox()");
    if (!isset($this->_mailbox)) {
      $uid = explode(static::DELIMITER, $this->uid, 2);
      $this->_user_uid = $uid[0];
      $this->_mailbox_uid = $uid[1];
      $class = $this->__getNamespace() . '\\User';
      $this->_mailbox = new $class($this->_server);
      $this->_mailbox->uid = $this->_mailbox_uid;
      if (!$this->_mailbox->load()) {
        $this->_mailbox = null;
      }
    }
    return $this->_mailbox;
  }

  /**
   * Est-ce que la mailbox de l'objet de partage existe ?
   * 
   * @return boolean
   */
  protected function issetMapMailbox() {
    M2Log::Log(M2Log::LEVEL_DEBUG, $this->get_class . "->issetMapMailbox()");
    $this->getMapMailbox();
    return isset($this->_mailbox);
  }

  /**
   * Retourne l'uid de l'utilisateur de l'objet de partage
   * 
   * @return string
   */
  protected function getMapUser_uid() {
    M2Log::Log(M2Log::LEVEL_DEBUG, $this->get_class . "->getMapUser_Uid()");
    if (!isset($this->_user_uid)) {
      $uid = explode(static::DELIMITER, $this->uid, 2);
      $this->_user_uid = $uid[0];
      $this->_mailbox_uid = $uid[1];
    }
    return $this->_user_uid;
  }

  /**
   * Retourne l'uid de la boite possedant l'objet de partage
   * 
   * @return string
   */
  protected function getMapMailbox_uid() {
    M2Log::Log(M2Log::LEVEL_DEBUG, $this->get_class . "->getMapMailbox_uid()");
    if (!isset($this->_mailbox_uid)) {
      $uid = explode(static::DELIMITER, $this->uid, 2);
      $this->_user_uid = $uid[0];
      $this->_mailbox_uid = $uid[1];
    }
    return $this->_mailbox_uid;
  }

  /**
   * Retourne le delimiteur utilisé pour reconnaitre les objets de partages
   * 
   * @return string
   */
  protected function getMapDelimiter() {
    M2Log::Log(M2Log::LEVEL_DEBUG, $this->get_class . "->getMapDelimiter()");
    return static::DELIMITER;
  }
}