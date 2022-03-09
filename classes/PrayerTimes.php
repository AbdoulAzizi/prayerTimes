<?php

class PrayerTimes {

    public $azan_name;
    public $iqamah_name;
    public $masjid_name;
    public $current_time;
    public $next_prayer;
    public $site_link;

    public function __construct() {

      $this->_xml_params = simplexml_load_file('./data/params.xml');
        $this->azan_name =  ['en' => 'Azan','ar' => 'الأذان'];
        $this->iqamah_name = ['en' => 'Iqamah','ar' => 'الإقامة'];
        $this->masjid_name = ['en' => $this->get_masjid_names()['en'], 'ar' => $this->get_masjid_names()['ar']];

        // set default timezone
        date_default_timezone_set($this->_xml_params->timezone);      
        // get current time
        $this->current_time = time();

        // get current hour
        $this->current_hour = date('H', $this->current_time);

        // get current minute
        $this->current_minute = date('i', $this->current_time);
        
        // initialize today prayer and iqamah times
        // get iqamah time from iqamah.xml file

        $this->fajr_iqamah_minutes = $this->get_iqamah_minutes('fajr');
        $this->zuhr_iqamah_minutes = $this->get_iqamah_minutes('zuhr');
        $this->asr_iqamah_minutes = $this->get_iqamah_minutes('asr');
        $this->maghrib_iqamah_minutes = $this->get_iqamah_minutes('maghrib');
        $this->isha_iqamah_minutes = $this->get_iqamah_minutes('isha');
        // get current hijr date
        $this->current_hijr_date = $this->get_hijr_date($this->current_time);
        $this->today_prayer_times = $this->get_today_prayer_times();
        $this->next_prayer = $this->get_next_prayer_time();
        $this->current_prayer = $this->get_current_prayer_time();
        // get site link from params.xml file
        $this->site_link = $this->get_site_link();

    }

    // get site link from params.xml file
    public function get_site_link() {
        foreach ($this->_xml_params->site_link as $link) {
            return $link->url;
        }
    }

    // get_iqamah_time function
    // get iqamah time from iqamah.xml file
    public function get_iqamah_minutes($prayer_name) {
        $iqamah_time = 0;
        // $iqamah_xml = simplexml_load_file('./data/params.xml');
        foreach ($this->_xml_params->prayer as $prayer) {
            if ($prayer->name == $prayer_name) {
                $iqamah_time = $prayer->iqamah;
            }
        }
        return $iqamah_time;
    }

    // get_masjid_name function
    // get masjid name from params.xml file
    public function get_masjid_names() {
        $masjid_name = [];
        // $masjid_xml = simplexml_load_file('./data/params.xml');
        foreach ($this->_xml_params->masjid as $masjid) {
            $masjid_name_en = $masjid->name;
            $masjid_name_ar = $masjid->name_ar;

            $masjid_name['en'] = $masjid_name_ar;
            $masjid_name['ar'] = $masjid_name_en;
            
        }
        return $masjid_name;
    }

    // get current hijr date
    public function get_hijr_date($time){
        
      $Arabic = new Arabic_Date(); // create new instance of Arabic_Date class
      // $Arabic->setMode(1);
      $correction = $Arabic->dateCorrection ($time);    
        
      $current_hijr_date = $Arabic->date('dS',  $this->time, $correction).' '.$Arabic->date('F',  $time, $correction).', '.$Arabic->date('Y', $time, $correction);

      return $current_hijr_date;
    }

    // get azan name
    public function get_azan_name() {
        return $this->azan_name['en'] . ' (' . $this->azan_name['ar'] . ')';
    }

    // get iqamah name
    public function get_iqamah_name() {
        return $this->iqamah_name['en'] . ' (' . $this->iqamah_name['ar'] . ')';
    }

    // get majid name
    public function get_masjid_name() {
        return $this->masjid_name['en'] . ' (' . $this->masjid_name['ar'] . ')';
    }
  
    public function get_months($month_number){
  
      switch ($month_number) {
        case 1:
          $month_name = ['ar' => 'يناير', 'fr' => 'Janvier'];
          break;
        case 2:
          $month_name = ['ar' => 'فبراير', 'fr' => 'Février'];
          break;
        case 3:
          $month_name = ['ar' => 'مارس', 'fr' => 'Mars'];
          break;
        case 4:
          $month_name = ['ar' => 'أبريل', 'fr' => 'Avril'];
          break;
        case 5:
          $month_name = ['ar' => 'مايو', 'fr' => 'Mai'];
          break;
        case 6:
          $month_name = [ 'ar' => 'يونيو', 'fr' => 'Juin'];
          break;
        case 7:
          $month_name = ['ar' => 'يوليو', 'fr' => 'Juillet'];
          break;
        case 8:
          $month_name = ['ar' => 'أغسطس', 'fr' => 'Août'];
          break;
        case 9:
          $month_name = ['ar' => 'سبتمبر', 'fr' => 'Septembre'];
          break;
        case 10:
          $month_name = ['ar' => 'أكتوبر', 'fr' => 'Octobre'];
          break;
        case 11:
          $month_name = ['ar' => 'نوفمبر', 'fr' => 'Novembre'];
          break;
        case 12:
          $month_name = ['ar' => 'ديسمبر', 'fr' => 'Décembre'];
          break;
        default:
          $month_name = ['en' => '', 'ar' => ''];
          break;
      }
           
        return $month_name;
         
    }
  
    // get prayer azan and iqamah times
    public function get_prayer_time($prayer_name){
  
      $prayer_time = $this->today_prayer_times[$prayer_name];

      return $prayer_time;
    }

    // get current prayer time based on current time
    public function get_current_prayer_time(){
  
      $fajr_time = $this->get_prayer_time('fajr');
      $zuhr_time = $this->get_prayer_time('zuhr');
      $asr_time = $this->get_prayer_time('asr');
      $maghrib_time = $this->get_prayer_time('maghrib');
      $isha_time = $this->get_prayer_time('isha');

      $current_prayer_time = '';
      $current_prayer_name = '';
      $now = date('H:i', $this->current_time);

      if( $now < $fajr_time){
        $current_prayer_time = $fajr_time;
        $current_prayer_name = $this->get_prayer_name('fajr');
      }else if ($now >= $fajr_time && $now < $zuhr_time) {
        $current_prayer_time = $fajr_time;
        $current_prayer_name = $this->get_prayer_name('fajr');
      } else if ($now >= $zuhr_time && $now < $asr_time) {
        $current_prayer_time = $zuhr_time;
        $current_prayer_name = $this->get_prayer_name('zuhr');
      } else if ($now >= $asr_time && $now < $maghrib_time) {
        $current_prayer_time = $asr_time;
        $current_prayer_name = $this->get_prayer_name('asr');
      } else if ($now >= $maghrib_time && $now < $isha_time) {
        $current_prayer_time = $maghrib_time;
        $current_prayer_name = $this->get_prayer_name('maghrib');
      } else if ($now >= $isha_time) {
        $current_prayer_time = $isha_time;
        $current_prayer_name = $this->get_prayer_name('isha');
      }

      return ['time' => $current_prayer_time, 'iqamah' => $this->get_iqamah_time($current_prayer_name), 'name' => $current_prayer_name];
      
    }

   
    // get the next prayer time depending on the current time
    public function get_next_prayer_time(){
      $current_time = date('H:i', $this->current_time);
      $time = strtotime($current_time);
      $today_prayer_times = $this->get_today_prayer_times();
      $next_prayer_time = '';
      $next_prayer_name = '';

      foreach ($today_prayer_times as $prayer_name => $prayer_time) {
        $prayer_time = strtotime($prayer_time);
        if ($time < $prayer_time && $prayer_name != 'sunrise' && $prayer_name != 'sunset') {
          $next_prayer_time = $prayer_time;
          $next_prayer_name = $prayer_name;
          break;
        }else{
          // set next prayer time to next day fajr
        $next_prayer_time = strtotime($this->get_next_day_prayer_times()['fajr']);
        $next_prayer_name = 'fajr';
    
        }
      }

      
      $next_prayer_time = date('H:i', $next_prayer_time);
      $iqamah_time = $this->get_iqamah_time($next_prayer_name);
      $next_prayer_name = $this->get_prayer_name($next_prayer_name);

      $next_prayer_time_array = [
        'time' => $next_prayer_time,
        'iqamah' => $iqamah_time,
        'name' => $next_prayer_name
      ];

      return $next_prayer_time_array;
      
    }

    // get today prayers times
    public function get_today_prayer_times(){
      $pt = new PrayTime();   
      $timestamp = $this->current_time;
      $year = date('Y', $timestamp);
      $month = date('m', $timestamp);
      $day = date('d', $timestamp);
     
      // get latitide, longitude and timezone from params.xml file
      $params = $this->get_params();
      $latitude = $params['latitude'];
      $longitude = $params['longitude'];
      $timezone = $params['timezone'];

      $today_prayer_times = $pt->getDatePrayerTimes($year, $month, $day, $latitude, $longitude, $timezone);


      // changeto the today_prayer_times array keys to match the prayer_times array keys
      $today_prayer_times = array(
        'fajr' => $today_prayer_times[0],
        'sunrise' => $today_prayer_times[1],
        'zuhr' => $today_prayer_times[2],
        'asr' => $today_prayer_times[3],
        'sunset' => $today_prayer_times[4],
        'maghrib' => $today_prayer_times[5],
        'isha' => $today_prayer_times[6]
      );   
      return $today_prayer_times;

    }

    // get get_params from params.xml file
    public function get_params(){
     
      foreach ($this->_xml_params->location as $location) {
        $params = [
          'latitude' => $location->latitude,
          'longitude' => $location->longitude,
          'timezone' => $location->timezone
        ];
      }
      return $params;
    }
     // get next day prayer times
     public function get_next_day_prayer_times(){
      $pt = new PrayTime();   
      // get next day prayer times
      $timestamp = strtotime('+1 day', $this->current_time);
      $year = date('Y', $timestamp);
      $month = date('m', $timestamp);
      $day = date('d', $timestamp);
      $latidude_montreal = 45.5017;
      $longitude_montreal = -73.5673;
      $timezone_montreal = -5;

      $next_day_prayer_times = $pt->getDatePrayerTimes($year, $month, $day, $latidude_montreal, $longitude_montreal, $timezone_montreal);

      // changeto the today_prayer_times array keys to match the prayer_times array keys
      $next_day_prayer_times = array(
        'fajr' => $next_day_prayer_times[0],
        'sunrise' => $next_day_prayer_times[1],
        'zuhr' => $next_day_prayer_times[2],
        'asr' => $next_day_prayer_times[3],
        'sunset' => $next_day_prayer_times[4],
        'maghrib' => $next_day_prayer_times[5],
        'isha' => $next_day_prayer_times[6]
      );

      return $next_day_prayer_times;
    }


     // get iqaamah time
     public function get_iqamah_time($prayer_name){
      $prayer_name = strtolower($prayer_name);
      $iqamah_munites = $prayer_name . '_iqamah_minutes';
      $prayer_time = $this->get_today_prayer_times()[$prayer_name];
      $prayer_time = strtotime($prayer_time);
      $iqamah_time = $prayer_time + ($this->$iqamah_munites * 60);
      $iqamah_time = date('H:i', $iqamah_time);
  
      return $iqamah_time;
    }


    // get the prayer name
    public function get_prayer_name($prayer_name){
      
      return ucfirst($prayer_name);
    }

    // get prayer name in arabic
    public function get_prayer_name_ar($prayer_name){
      $prayer_name_ar = [
        'fajr' => 'الفجر',
        'shurooq' => 'الشروق',
        'zuhr' => 'الظهر',
        'asr' => 'العصر',
        'maghrib' => 'المغرب',
        'isha' => 'العشاء'
      ];
      return $prayer_name_ar[$prayer_name];

    }

  
  }
  