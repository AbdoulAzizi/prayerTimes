<?php

class PrayerTimes {

    public $azan_name;
    public $iqamah_name;
    public $masjid_name;
    public $current_time;
    public $next_prayer;
    public $site_link;

    public function __construct() {


        $this->azan_name =  ['en' => 'Azan','ar' => 'الأذان'];
        $this->iqamah_name = ['en' => 'Iqamah','ar' => 'الإقامة'];
        $this->masjid_name = ['en' => 'Mosquee Dhoun Nourain','ar' => 'مسجد ذو النورين'];

        // set default timezone
        date_default_timezone_set('America/Montreal');
      
        // get current time
        $this->current_time = time();
        
        // initialize today prayer and iqamah times
        $this->fajr_iqamah_minutes = 15;
        $this->zuhr_iqamah_minutes = 10;
        $this->asr_iqamah_minutes = 10;
        $this->maghrib_iqamah_minutes = 5;
        $this->isha_iqamah_minutes = 15;

        // get current hijr date
        $this->current_hijr_date = $this->get_hijr_date($this->current_time);
        $this->today_prayer_times = $this->get_today_prayer_times();
        $this->next_prayer = $this->get_next_prayer_time();

        // this site link
        $this->site_link = 'www.salafidemontreal.com';
    }

    // get current hijr date
    public function get_hijr_date($time){
        
      $Arabic = new I18N_Arabic_Date(); // create new instance of I18N_Arabic_Date class
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
      $latidude_montreal = 45.5017;
      $longitude_montreal = -73.5673;
      $timezone_montreal = -5;

      $today_prayer_times = $pt->getDatePrayerTimes($year, $month, $day, $latidude_montreal, $longitude_montreal, $timezone_montreal);


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
  