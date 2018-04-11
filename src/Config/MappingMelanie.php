<?php
/**
 * Ce fichier est développé pour la gestion de la librairie Mélanie2
 * Cette Librairie permet d'accèder aux données sans avoir à implémenter de couche SQL
 * Des objets génériques vont permettre d'accèder et de mettre à jour les données
 *
 * ORM M2 Copyright © 2017  PNE Annuaire et Messagerie/MEDDE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace LibMelanie\Config;

/**
 * Configuration du mapping vers Melanie2
 *
 * @author PNE Messagerie/Apitech
 * @package Librairie Mélanie2
 * @subpackage Config
 */
class MappingMelanie {
	// Mapping SQL
	/**
	 * Tables associées aux objets
	 * @var array
	 */
	public static $Table_Name = [];

	/**
	 * Clés primaires des tables Melanie2
	 * @var array
	*/
	public static $Primary_Keys = [];

	/**
	 * Gestion du mapping entre les données et les champs de la base de données
	 * need name, type if != string, format for datetime (user constants)
	 * @var array
	*/
	public static $Data_Mapping = [];
	
	/**
	 * Initialisation du mapping
	 */
	public static function Init() {
	  // Init Tables Name
	  self::$Table_Name = [
	      "EventMelanie" 				=> "kronolith_events",
	      "HistoryMelanie" 			=> "horde_histories",
	      "TaskMelanie" 				=> "nag_tasks",
	      "ContactMelanie" 			=> "turba_objects",
	      "EventProperties" 		=> "lightning_attributes",
	      "TaskProperties" 			=> "lightning_attributes",
	      "AttachmentMelanie" 	=> "horde_vfs",
	      "CalendarMelanie" 		=> "horde_datatree",
	      "CalendarSync" 				=> "kronolith_sync",
	      "TaskslistSync" 			=> "nag_sync",
	      "TaskslistMelanie" 		=> "horde_datatree",
	      "AddressbookMelanie" 	=> "horde_datatree",
	      "UserPrefs" 					=> "horde_prefs",
	      "Share" 							=> "horde_datatree_attributes",
	  ];
	  // Init Primary Keys
	  self::$Primary_Keys = [
	      "UserMelanie" 				=> ["uid", "email"],
	      "EventMelanie" 				=> ["uid", "calendar"],
	      "HistoryMelanie" 			=> ["uid", "action"],
	      "TaskMelanie" 				=> ["uid", "taskslist"],
	      "ContactMelanie" 			=> ["uid", "addressbook"],
	      "EventProperties" 		=> ["event", "calendar", "user", "key"],
	      "TaskProperties" 			=> ["task", "taskslist", "user", "key"],
	      "AttachmentMelanie" 	=> ["path", "name"],
	      "CalendarMelanie" 		=> ["id", "owner", "group"],
	      "CalendarSync" 				=> ["token", "calendar"],
	      "TaskslistSync" 			=> ["token", "taskslist"],
	      "TaskslistMelanie" 		=> ["id", "owner", "group"],
	      "AddressbookMelanie" 	=> ["id", "owner", "group"],
	      "UserPrefs" 					=> ["user", "scope", "name"],
	      "Share" 							=> ["object_id", "name"],
	  ];
	  // Init Data Mapping
	  self::$Data_Mapping = [
	      // Gestion de l'utilisateur : objet UserMelanie
	      "UserMelanie" => [
	          "uid"                    => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_uid', "uid"), self::type => self::stringLdap],
	          "fullname"               => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_cn', "cn"), self::type => self::stringLdap],
	          "name"                   => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_displayname', "displayname"), self::type => self::stringLdap],
	          "email"                  => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_principal', "mailpr"), self::type => self::stringLdap],
	          "email_list"             => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mels_list', "mail"), self::type => self::arrayLdap],
	          "email_send"             => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_emission', "mineqmelmailemissionpr"), self::type => self::stringLdap],
	          "email_send_list"        => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mels_emission_list', "mineqmelmailemission"), self::type => self::arrayLdap],
	          "service"                => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_service', "departmentnumber"), self::type => self::stringLdap],
	          "password_need_change"   => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_pwd_change', "mineqpassworddoitchanger"), self::type => self::stringLdap],
	          "shares"                 => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_partages', "mineqmelpartages"), self::type => self::arrayLdap],
	          "away_response"          => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_response', "mineqmelreponse"), self::type => self::stringLdap],
	          "internet_access_admin"  => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_accesinterneta', "mineqmelaccesinterneta"), self::type => self::stringLdap],
	          "internet_access_user"   => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_accesinternetu', "mineqmelaccesinternetu"), self::type => self::stringLdap],
	          "use_photo_ader"         => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_photo_publiader', "mineqPublicationPhotoAder"), self::type => self::stringLdap],
	          "use_photo_intranet"     => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_photo_publiintra', "mineqPublicationPhotoIntranet"), self::type => self::stringLdap],
	          "employee_number"        => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_employeenumber', "employeenumber"), self::type => self::stringLdap],
	          "zone"                   => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_zone', "mineqzone"), self::type => self::stringLdap],
	          "street"                 => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_street', "street"), self::type => self::stringLdap],
	          "postalcode"             => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_postalcode', "postalcode"), self::type => self::stringLdap],
	          "locality"               => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_locality', "l"), self::type => self::stringLdap],
	          "info"                   => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_info', "info"), self::type => self::arrayLdap],
	          "description"            => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_description', "description"), self::type => self::stringLdap],
	          "phonenumber"            => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_phonenumber', "telephonenumber"), self::type => self::stringLdap],
	          "faxnumber"              => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_faxnumber', "facsimiletelephonenumber"), self::type => self::stringLdap],
	          "mobilephone"            => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mobilephone', "mobile"), self::type => self::stringLdap],
	          "roomnumber"             => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_roomnumber', "roomnumber"), self::type => self::stringLdap],
	          "title"                  => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_title', "title"), self::type => self::stringLdap],
	          "business_category"      => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_businesscat', "businesscategory"), self::type => self::stringLdap],
	          "vpn_profile"            => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_vpnprofil', "mineqvpnprofil"), self::type => self::stringLdap],
	          "update_personnal_info"  => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_majinfoperso', "mineqmajinfoperso"), self::type => self::stringLdap],
	          "synchro_access_admin"   => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_accessynchroa', "mineqmelaccessynchroa"), self::type => self::stringLdap],
	          "synchro_access_user"    => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_accessynchrou', "mineqmelaccessynchrou"), self::type => self::stringLdap],
	          "server_routage"         => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mel_routage', "mineqmelroutage"), self::type => self::arrayLdap],
	          "mission"                => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_mission', "mineqmission"), self::type => self::stringLdap],
	          "photo"                  => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_photo', "jpegphoto"), self::type => self::stringLdap],
	          "gender"                 => [self::name => \LibMelanie\Ldap\Ldap::GetMap('user_gender', "gender"), self::type => self::stringLdap],
	      ],
	      // Gestion des préférences de l'utilisateur : objet UserPrefs
	      "UserPrefs" => [
	          "user" 	=> [self::name => "pref_uid", self::type => self::string, self::size => 255],
	          "scope" => [self::name => "pref_scope", self::type => self::string, self::size => 16],
	          "name" 	=> [self::name => "pref_name", self::type => self::string, self::size => 32],
	          "value" => [self::name => "pref_value"],
	      ],
	      // Gestion des partages de l'utilisateur : objet Share
	      "Share" => [
	          "object_id" => [self::name => "datatree_id", self::type => self::integer],
	          "name" 			=> [self::name => "attribute_key", self::type => self::string, self::size => 255],
	          "type" 			=> [self::name => "attribute_name", self::type => self::string, self::size => 255],
	          "acl" 			=> [self::name => "attribute_value"],
	      ],
	      // Gestion du calendrier : objet CalendarMelanie
	      "CalendarMelanie" => [
	          "id" 				=> [self::name => "calendar_id"],
	          "owner" 		=> [self::name => "calendar_owner", self::defaut => ''],
	          "name" 			=> [self::name => "calendar_name", self::defaut => ''],
	          "ctag" 			=> [self::name => "calendar_ctag"],
	          "synctoken" => [self::name => "calendar_synctoken"],
	          "perm" 			=> [self::name => "perm_calendar"],
	          "object_id" => [self::name => "datatree_id"],
	          "group" 		=> [self::name => "group_uid", self::defaut => ConfigMelanie::CALENDAR_GROUP_UID],
	      ],
	      // Gestion de la liste de tâches : objet TaskslistMelanie
	      "TaskslistMelanie" => [
	          "id" 				=> [self::name => "task_owner"],
	          "owner" 		=> [self::name => "taskslist_owner", self::defaut => ''],
	          "name" 			=> [self::name => "taskslist_name", self::defaut => ''],
	          "ctag" 			=> [self::name => "taskslist_ctag"],
	          "synctoken" => [self::name => "taskslist_synctoken"],
	          "perm" 			=> [self::name => "perm_taskslist"],
	          "object_id" => [self::name => "datatree_id"],
	          "group" 		=> [self::name => "group_uid", self::defaut => ConfigMelanie::TASKSLIST_GROUP_UID],
	      ],
	      // Gestion de la liste de contacts : objet AddressbookMelanie
	      "AddressbookMelanie" => [
	          "id" 				=> [self::name => "owner_id"],
	          "owner" 		=> [self::name => "addressbook_owner", self::defaut => ''],
	          "name" 			=> [self::name => "addressbook_name", self::defaut => ''],
	          "ctag" 			=> [self::name => "addressbook_ctag"],
	          "synctoken" => [self::name => "addressbook_synctoken"],
	          "perm" 			=> [self::name => "perm_addressbook"],
	          "object_id" => [self::name => "datatree_id"],
	          "group" 		=> [self::name => "group_uid", self::defaut => ConfigMelanie::ADDRESSBOOK_GROUP_UID],
	      ],
	      // Gestion de l'historique : objet HistoryMelanie
	      "HistoryMelanie" => [
	          "id" 					=> [self::name => "history_id", self::type => self::integer],
	          "uid" 				=> [self::name => "object_uid"],
	          "action" 			=> [self::name => "history_action"],
	          "timestamp" 	=> [self::name => "history_ts", self::type => self::timestamp, self::defaut => 0],
	          "description" => [self::name => "history_desc"],
	          "who" 				=> [self::name => "history_who"],
	          "extra" 			=> [self::name => "history_extra"]
	      ],
	      // Gestion des évènements : objet EventMelanie
	      "EventMelanie" => [
	          "uid" 			=> [self::name => "event_uid", self::type => self::string, self::size => 255],
	          "realuid" 			=> [self::name => "event_realuid", self::type => self::string, self::size => 255],
	          "calendar" 	=> [self::name => "calendar_id", self::type => self::string, self::size => 255],
	          "id" 				=> [self::name => "event_id", self::type => self::string, self::size => 64],
	          "owner" 		=> [self::name => "event_creator_id", self::type => self::string, self::size => 255, self::defaut => ''],
	          "keywords" 	=> [self::name => "event_keywords"],
	          
	          // DATA
	          "title" 			  => [self::name => "event_title", self::type => self::string, self::size => 255, self::defaut => ''],
	          "description"   => [self::name => "event_description", self::defaut => ''],
	          "category" 		  => [self::name => "event_category", self::type => self::string, self::size => 80, self::defaut => ''],
	          "location" 		  => [self::name => "event_location", self::defaut => ''],
	          "status" 			  => [self::name => "event_status", self::type => self::integer, self::defaut => 2],
	          "class" 			  => [self::name => "event_private", self::type => self::integer, self::defaut => 0],
	          "sequence" 			=> [self::name => "event_sequence", self::type => self::integer, self::defaut => 0],
	          "priority" 			=> [self::name => "event_priority", self::type => self::integer, self::defaut => 0],
	          "alarm" 			  => [self::name => "event_alarm", self::type => self::integer, self::defaut => 0],
	          "is_deleted"    => [self::name => "event_is_deleted", self::type => self::integer, self::defaut => 0],
	          "is_exception"  => [self::name => "event_is_exception", self::type => self::integer, self::defaut => 0],
	          "transparency" 	=> [self::name => "event_transparency", self::type => self::string, self::size => 10, self::defaut => 'opaque'],
	          "properties" 	  => [self::name => "event_properties_json"],
	          
	          // ATTENDEES
	          "attendees" 	           => [self::name => "event_attendees"],
	          "organizer_json" 	       => [self::name => "event_organizer_json"],
	          "organizer_calendar_id"  => [self::name => "organizer_calendar_id"],
	          
	          // TIME
	          "all_day"  	    => [self::name => "event_all_day", self::type => self::integer, self::defaut => 0],
	          "start" 		    => [self::name => "event_start", self::type => self::date, self::format => "Y-m-d H:i:s"],
	          "end" 			    => [self::name => "event_end", self::type => self::date, self::format => "Y-m-d H:i:s"],
	          "created" 	    => [self::name => "event_created", self::type => self::timestamp, self::defaut => 0],
	          "modified" 	    => [self::name => "event_modified", self::type => self::timestamp, self::defaut => 0],
	          "modified_json" => [self::name => "event_modified_json", self::type => self::timestamp, self::defaut => 0],
	          "timezone"      => [self::name => "event_timezone", self::type => self::string, self::defaut => 'Europe/Paris'],
	          
	          // RECURRENCE
	          "exceptions" 			=> [self::name => "event_exceptions"],
	          "enddate" 				=> [self::name => "event_recurenddate",self::type => self::date, self::format => "Y-m-d H:i:s"],
	          "count" 					=> [self::name => "event_recurcount", self::type => self::integer],
	          "interval" 				=> [self::name => "event_recurinterval", self::type => self::integer],
	          "type" 						=> [self::name => "event_recurtype", self::type => self::integer, self::defaut => 0],
	          "days" 						=> [self::name => "event_recurdays", self::type => self::integer],
	          "recurrence_id" 	=> [self::name => "event_recurrence_id", self::type => self::date],
	          "recurrence_json" => [self::name => "event_recurrence_json"],
	      ],
	      // Gestion des propriétés des évènements : objet EventProperties
	      "EventProperties" => [
	          "event" 		=> [self::name => "event_uid", self::type => self::string, self::size => 255],
	          "calendar" 	=> [self::name => "calendar_id", self::type => self::string, self::size => 255],
	          "user" 			=> [self::name => "user_uid", self::type => self::string, self::size => 255],
	          "key" 			=> [self::name => "attribute_key", self::type => self::string, self::size => 255],
	          "value" 		=> [self::name => "attribute_value"],
	      ],
	      // Gestion des propriétés des tâches : objet TaskProperties
	      "TaskProperties" => [
	          "task" 			=> [self::name => "event_uid", self::type => self::string, self::size => 255],
	          "taskslist" => [self::name => "calendar_id", self::type => self::string, self::size => 255],
	          "user" 			=> [self::name => "user_uid", self::type => self::string, self::size => 255],
	          "key" 			=> [self::name => "attribute_key", self::type => self::string, self::size => 255],
	          "value" 		=> [self::name => "attribute_value"],
	      ],
	      // Gestion des pièces jointes dans les évènements : objet AttachmentMelanie
	      "AttachmentMelanie" => [
	          "id" => [self::name => "vfs_id", self::type => self::integer],
	          "type" 			=> [self::name => "vfs_type", self::type => self::integer],
	          "path" 			=> [self::name => "vfs_path", self::type => self::string, self::size => 255],
	          "name" 			=> [self::name => "vfs_name", self::type => self::string, self::size => 255],
	          "modified" 	=> [self::name => "vfs_modified", self::type => self::integer, self::defaut => 0],
	          "owner" 		=> [self::name => "vfs_owner", self::type => self::string, self::size => 255],
	          "data" 			=> [self::name => "vfs_data", self::type => self::string],
	      ],
	      // Gestion des SyncToken pour le calendrier : objet CalendarSync
	      "CalendarSync" => [
	          "token" 		=> [self::name => "token", self::type => self::integer],
	          "calendar" 	=> [self::name => "calendar_id", self::type => self::string, self::size => 255],
	          "uid" 			=> [self::name => "event_uid", self::type => self::string, self::size => 255],
	          "action" 		=> [self::name => "action", self::type => self::string, self::size => 3],
	      ],
	      // Gestion des SyncToken pour la liste de tâches : objet TaskslistSync
	      "TaskslistSync" => [
	          "token" 		=> [self::name => "token", self::type => self::integer],
	          "taskslist" 	=> [self::name => "taskslist_id", self::type => self::string, self::size => 255],
	          "uid" 			=> [self::name => "task_uid", self::type => self::string, self::size => 255],
	          "action" 		=> [self::name => "action", self::type => self::string, self::size => 3],
	      ],
	      // Gestion des tâches : objet TaskMelanie
	      "TaskMelanie" => [
	          "id" 				=> [self::name => "task_id", self::type => self::string, self::size => 32],
	          "taskslist" => [self::name => "task_owner", self::type => self::string, self::size => 255],
	          "uid" 			=> [self::name => "task_uid", self::type => self::string, self::size => 255],
	          "owner" 		=> [self::name => "task_creator", self::type => self::string, self::size => 255],
	          
	          // DATA
	          "name" 				=> [self::name => "task_name", self::type => self::string, self::size => 255],
	          "description" => [self::name => "task_desc"],
	          "priority" 		=> [self::name => "task_priority", self::type => self::integer],
	          "category" 		=> [self::name => "task_category", self::type => self::string, self::size => 80],
	          "completed" 	=> [self::name => "task_completed", self::type => self::integer],
	          "alarm" 			=> [self::name => "task_alarm"],
	          "class" 			=> [self::name => "task_private", self::type => self::integer],
	          "assignee" 		=> [self::name => "task_assignee", self::type => self::string, self::size => 255],
	          "estimate" 		=> [self::name => "task_estimate", self::type => self::double],
	          "parent" 			=> [self::name => "task_parent", self::type => self::string, self::size => 32],
	          
	          // TIME
	          "due" 						=> [self::name => "task_due", self::type => self::timestamp],
	          "completed_date" 	=> [self::name => "task_completed_date", self::type => self::timestamp],
	          "start" 					=> [self::name => "task_start", self::type => self::timestamp],
	          "modified" 				=> [self::name => "task_ts", self::type => self::timestamp, self::defaut => 0]
	      ],
	      // Gestion des contacts : objet ContactMelanie
	      "ContactMelanie" => [
	          "id" 					=> [self::name => "object_id", self::type => self::string, self::size => 32],
	          "addressbook" => [self::name => "owner_id", self::type => self::string, self::size => 255],
	          "uid" 				=> [self::name => "object_uid", self::type => self::string, self::size => 255],
	          "type" 				=> [self::name => "object_type", self::type => self::string, self::size => 255],
	          "modified" 		=> [self::name => "object_ts", self::type => self::timestamp, self::defaut => 0],
	          
	          // DATA
	          "members" 		=> [self::name => "object_members"],
	          "name" 				=> [self::name => "object_name", self::type => self::string, self::size => 255],
	          "alias" 			=> [self::name => "object_alias", self::type => self::string, self::size => 32],
	          "freebusyurl" => [self::name => "object_freebusyurl", self::type => self::string, self::size => 255],
	          "firstname" 	=> [self::name => "object_firstname", self::type => self::string, self::size => 255],
	          "lastname" 		=> [self::name => "object_lastname", self::type => self::string, self::size => 255],
	          "middlenames" => [self::name => "object_middlenames", self::type => self::string, self::size => 255],
	          "nameprefix" 	=> [self::name => "object_nameprefix", self::type => self::string, self::size => 255],
	          "namesuffix" 	=> [self::name => "object_namesuffix", self::type => self::string, self::size => 32],
	          "birthday" 		=> [self::name => "object_bday", self::type => self::string, self::size => 10],
	          
	          "title" 	=> [self::name => "object_title", self::type => self::string, self::size => 255],
	          "company" => [self::name => "object_company", self::type => self::string, self::size => 255],
	          "notes" 	=> [self::name => "object_notes"],
	          
	          "email" 	=> [self::name => "object_email", self::type => self::string, self::size => 255],
	          "email1" 	=> [self::name => "object_email1", self::type => self::string, self::size => 255],
	          "email2" 	=> [self::name => "object_email2", self::type => self::string, self::size => 255],
	          
	          "cellphone" => [self::name => "object_cellphone", self::type => self::string, self::size => 25],
	          "fax" 			=> [self::name => "object_fax", self::type => self::string, self::size => 25],
	          
	          "category" 	=> [self::name => "object_category", self::type => self::string, self::size => 80],
	          "url" 			=> [self::name => "object_url", self::type => self::string, self::size => 255],
	          // HOME
	          "homeaddress" 		=> [self::name => "object_homeaddress", self::type => self::string, self::size => 255],
	          "homephone" 			=> [self::name => "object_homephone", self::type => self::string, self::size => 25],
	          "homestreet" 			=> [self::name => "object_homestreet", self::type => self::string, self::size => 255],
	          "homepob" 				=> [self::name => "object_homepob", self::type => self::string, self::size => 10],
	          "homecity" 				=> [self::name => "object_homecity", self::type => self::string, self::size => 255],
	          "homeprovince" 		=> [self::name => "object_homeprovince", self::type => self::string, self::size => 255],
	          "homepostalcode" 	=> [self::name => "object_homepostalcode", self::type => self::string, self::size => 255],
	          "homecountry" 		=> [self::name => "object_homecountry", self::type => self::string, self::size => 255],
	          // WORK
	          "workaddress" 		=> [self::name => "object_workaddress", self::type => self::string, self::size => 255],
	          "workphone" 			=> [self::name => "object_workphone", self::type => self::string, self::size => 25],
	          "workstreet" 			=> [self::name => "object_workstreet", self::type => self::string, self::size => 255],
	          "workpob" 				=> [self::name => "object_workpob", self::type => self::string, self::size => 10],
	          "workcity" 				=> [self::name => "object_workcity", self::type => self::string, self::size => 255],
	          "workprovince" 		=> [self::name => "object_workprovince", self::type => self::string, self::size => 255],
	          "workpostalcode" 	=> [self::name => "object_workpostalcode", self::type => self::string, self::size => 255],
	          "workcountry" 		=> [self::name => "object_workcountry", self::type => self::string, self::size => 255],
	          
	          "pgppublickey" 		=> [self::name => "object_pgppublickey"],
	          "smimepublickey" 	=> [self::name => "object_smimepublickey"],
	          
	          "photo" 		=> [self::name => "object_photo"],
	          "phototype" => [self::name => "object_phototype", self::type => self::string, self::size => 10],
	          "logo" 			=> [self::name => "object_logo"],
	          "logotype" 	=> [self::name => "object_logotype", self::type => self::string, self::size => 10],
	          
	          "timezone" 	=> [self::name => "object_tz", self::type => self::string, self::size => 32],
	          "geo" 			=> [self::name => "object_geo", self::type => self::string, self::size => 255],
	          "pager" 		=> [self::name => "object_pager", self::type => self::string, self::size => 25],
	          "role" 			=> [self::name => "object_role", self::type => self::string, self::size => 255]
	      ]
	  ];
	}

	// Mapping constants
	const name = "name";
	const type = "type";
	const size = "size";
	const format = "format";
	const string = "string";
	const integer = "integer";
	const double = "double";
	const date = "date";
	const arrayLdap = "arrayLdap";
	const stringLdap = "stringLdap";
	const timestamp = "timestamp";
	const defaut = "defaut";
	const sup = ">";
	const supeq = ">=";
	const inf = "<";
	const infeq = "<=";
	const diff = "<>";
	const like = "LIKE";
	const eq = "=";
	const in = "IN";

	// DATA MAPPING
	// Class
	const PRIV = 1;
	const PUB = 0;
	/**
	 * Class mapping
	 */
	public static $MapClassObjectMelanie = [
		ConfigMelanie::PRIV => self::PRIV,
		ConfigMelanie::PUB => self::PUB,
		ConfigMelanie::CONFIDENTIAL => self::PRIV,
		self::PRIV => ConfigMelanie::PRIV,
		self::PUB => ConfigMelanie::PUB
	];

	// Status
	const NONE = 4;
	const TENTATIVE = 1;
	const CONFIRMED = 2;
	const CANCELLED = 3;
	/**
	 * Status mapping
	 */
	public static $MapStatusObjectMelanie = [
			ConfigMelanie::TENTATIVE => self::TENTATIVE,
			ConfigMelanie::NONE => self::NONE,
			ConfigMelanie::CONFIRMED => self::CONFIRMED,
			ConfigMelanie::CANCELLED => self::CANCELLED,
			self::TENTATIVE => ConfigMelanie::TENTATIVE,
			self::CONFIRMED => ConfigMelanie::CONFIRMED,
			self::NONE => ConfigMelanie::NONE,
			self::CANCELLED => ConfigMelanie::CANCELLED
	];

	// Recurrence days
	const NODAY = 0;
	const SUNDAY = 1;
	const MONDAY = 2;
	const TUESDAY = 4;
	const WEDNESDAY = 8;
	const THURSDAY = 16;
	const FRIDAY = 32;
	const SATURDAY = 64;
	/**
	 * Recurdays mapping
	 */
	public static $MapRecurdaysObjectMelanie = [
			ConfigMelanie::NODAY => self::NODAY,
			ConfigMelanie::SUNDAY => self::SUNDAY,
			ConfigMelanie::MONDAY => self::MONDAY,
			ConfigMelanie::TUESDAY => self::TUESDAY,
			ConfigMelanie::WEDNESDAY => self::WEDNESDAY,
			ConfigMelanie::THURSDAY => self::THURSDAY,
			ConfigMelanie::FRIDAY => self::FRIDAY,
			ConfigMelanie::SATURDAY => self::SATURDAY,
			self::NODAY => ConfigMelanie::NODAY,
			self::SUNDAY => ConfigMelanie::SUNDAY,
			self::MONDAY => ConfigMelanie::MONDAY,
			self::TUESDAY => ConfigMelanie::TUESDAY,
			self::WEDNESDAY => ConfigMelanie::WEDNESDAY,
			self::THURSDAY => ConfigMelanie::THURSDAY,
			self::FRIDAY => ConfigMelanie::FRIDAY,
			self::SATURDAY => ConfigMelanie::SATURDAY
	];

	// Recurrence type
	const NORECUR = 0;
	const DAILY = 1;
	const WEEKLY = 2;
	const MONTHLY = 3;
	const MONTHLY_BYDAY = 4;
	const YEARLY = 5;
	const YEARLY_BYDAY = 6;
	/**
	 * Recurtype mapping
	 */
	public static $MapRecurtypeObjectMelanie = [
			ConfigMelanie::NORECUR => self::NORECUR,
			ConfigMelanie::DAILY => self::DAILY,
			ConfigMelanie::WEEKLY => self::WEEKLY,
			ConfigMelanie::MONTHLY => self::MONTHLY,
			ConfigMelanie::MONTHLY_BYDAY => self::MONTHLY_BYDAY,
			ConfigMelanie::YEARLY => self::YEARLY,
			ConfigMelanie::YEARLY_BYDAY => self::YEARLY_BYDAY,
			self::NORECUR => ConfigMelanie::NORECUR,
			self::DAILY => ConfigMelanie::DAILY,
			self::WEEKLY => ConfigMelanie::WEEKLY,
			self::MONTHLY => ConfigMelanie::MONTHLY,
			self::MONTHLY_BYDAY => ConfigMelanie::MONTHLY_BYDAY,
			self::YEARLY => ConfigMelanie::YEARLY,
			self::YEARLY_BYDAY => ConfigMelanie::YEARLY_BYDAY
	];

	// Attendee status
	const ATT_NEED_ACTION = 1;
	const ATT_ACCEPTED = 2;
	const ATT_DECLINED = 3;
	const ATT_TENTATIVE = 4;
	/**
	 * Attendee response mapping
	 */
	public static $MapAttendeeResponseObjectMelanie = [
			ConfigMelanie::NEED_ACTION => self::ATT_NEED_ACTION,
			ConfigMelanie::ACCEPTED => self::ATT_ACCEPTED,
			ConfigMelanie::DECLINED => self::ATT_DECLINED,
			ConfigMelanie::IN_PROCESS => self::ATT_NEED_ACTION,
			ConfigMelanie::TENTATIVE => self::ATT_TENTATIVE,
			self::ATT_NEED_ACTION => ConfigMelanie::NEED_ACTION,
			self::ATT_ACCEPTED => ConfigMelanie::ACCEPTED,
			self::ATT_DECLINED => ConfigMelanie::DECLINED,
			self::ATT_TENTATIVE => ConfigMelanie::TENTATIVE
	];

	// Attendee role	
	const REQ_PARTICIPANT = 1;
	const OPT_PARTICIPANT = 2;
	const NON_PARTICIPANT = 3;
	const CHAIR = 4;
	/**
	 * Attendee role mapping
	 */
	public static $MapAttendeeRoleObjectMelanie = [
			ConfigMelanie::CHAIR => self::CHAIR,
			ConfigMelanie::REQ_PARTICIPANT => self::REQ_PARTICIPANT,
			ConfigMelanie::OPT_PARTICIPANT => self::OPT_PARTICIPANT,
			ConfigMelanie::NON_PARTICIPANT => self::NON_PARTICIPANT,
			self::CHAIR => ConfigMelanie::CHAIR,
			self::REQ_PARTICIPANT => ConfigMelanie::REQ_PARTICIPANT,
			self::OPT_PARTICIPANT => ConfigMelanie::OPT_PARTICIPANT,
			self::NON_PARTICIPANT => ConfigMelanie::NON_PARTICIPANT
	];

	// Task priority
	const NO_PRIORITY = 0;
	const VERY_HIGH = 1;
	const HIGH = 2;
	const NORMAL = 3;
	const LOW = 4;
	const VERY_LOW = 5;
	/**
	 * Priority Mapping
	 */
	public static $MapPriorityObjectMelanie = [
	    ConfigMelanie::NO_PRIORITY => self::NO_PRIORITY,
			ConfigMelanie::VERY_HIGH => self::VERY_HIGH,
			ConfigMelanie::HIGH => self::HIGH,
			ConfigMelanie::NORMAL => self::NORMAL,
			ConfigMelanie::LOW => self::LOW,
			ConfigMelanie::VERY_LOW => self::VERY_LOW,
	    self::NO_PRIORITY => ConfigMelanie::NO_PRIORITY,
			self::VERY_HIGH => ConfigMelanie::VERY_HIGH,
			self::HIGH => ConfigMelanie::HIGH,
			self::NORMAL => ConfigMelanie::NORMAL,
			self::LOW => ConfigMelanie::LOW,
			self::VERY_LOW => ConfigMelanie::VERY_LOW
	];

	// Task completed
	const COMPLETED = 1;
	const NOTCOMPLETED = 0;
	/**
	 * Completed mapping
	 */
	public static $MapCompletedObjectMelanie = [
			ConfigMelanie::COMPLETED => self::COMPLETED,
			ConfigMelanie::NOTCOMPLETED => self::NOTCOMPLETED,
			self::COMPLETED => ConfigMelanie::COMPLETED,
			self::NOTCOMPLETED => ConfigMelanie::NOTCOMPLETED
	];
}

// Initialisation du mapping
MappingMelanie::Init();
