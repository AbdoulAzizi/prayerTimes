<?php

class PrayerTimes {

    public function __construct() {

      $time = time();

      $pt = new PrayTime();  

      $nex_prayer = $this->get_next_prayer_time();
      
            
      $Arabic = new I18N_Arabic('Date');
      // $Arabic->setMode(1);
      $correction = $Arabic->dateCorrection ($time);    
        
      $current_hijr_date = $Arabic->date('dS', $time, $correction).' '.$Arabic->date('F', $time, $correction).', '.$Arabic->date('Y', $time, $correction);
      
      $azan_name = [
        'en' => 'Azan',
        'ar' => 'الأذان'
      ];
      $iqamah_name = [
        'en' => 'Iqamah',
        'ar' => 'الإقامة'
      ];
      $majid_name = [
        'en' => 'Mosquee Dhoun Nourain',
        'ar' => 'مسجد ذو النورين'
      ];
      
  
      $time_array = getdate($time);
      
      // get current time
      $this->time = $time; 
  
      $this->azan_name = $azan_name['en'] . ' (' . $azan_name['ar'] . ')';
      $this->iqamah_name = $iqamah_name['en'] . ' (' . $iqamah_name['ar'] . ')';
      $this->majid_name = $majid_name['en'] . ' ' . $majid_name['ar'];

      // initialize today prayer and iqamah times

      $this->fajr_iqamah_minutes = 15;
      $this->dhuhr_iqamah_minutes = 10;
      $this->asr_iqamah_minutes = 10;
      $this->maghrib_iqamah_minutes = 5;
      $this->isha_iqamah_minutes = 15;

      // get current hijr date
      $this->current_hijr_date = $current_hijr_date;
      $this->today_prayer_times = $this->get_today_prayer_times();
      $this->nex_prayer = $nex_prayer;

      // this site link
      $this->site_link = 'www.salafidemontreal.com';
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
          $month_name = [ 'ar' => 'مارس', 'fr' => 'Mars'];
          break;
        case 4:
          $month_name = [ 'ar' => 'أبريل', 'fr' => 'Avril'];
          break;
        case 5:
          $month_name = [ 'ar' => 'مايو', 'fr' => 'Mai'];
          break;
        case 6:
          $month_name = [  'ar' => 'يونيو', 'fr' => 'Juin'];
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
      $time = time();
      $current_time = date('H:i', $time);
      $time = strtotime($current_time);
      $today_prayer_times = $this->get_today_prayer_times();
      $next_prayer_time = '';
      $next_prayer_name = '';

      foreach ($today_prayer_times as $prayer_name => $prayer_time) {
        $prayer_time = strtotime($prayer_time);
        if ($time < $prayer_time) {
          $next_prayer_time = $prayer_time;
          $next_prayer_name = $prayer_name;
          break;
        }else{
          // set next prayer time to fajr
          $next_prayer_time = strtotime($today_prayer_times['fajr']);
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
      $timestamp = time();
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
        'dhuhr' => $today_prayer_times[2],
        'asr' => $today_prayer_times[3],
        'sunset' => $today_prayer_times[4],
        'maghrib' => $today_prayer_times[5],
        'isha' => $today_prayer_times[6]
      );   
      return $today_prayer_times;

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
        'shuruk' => 'الشروق',
        'dhuhr' => 'الظهر',
        'asr' => 'العصر',
        'maghrib' => 'المغرب',
        'isha' => 'العشاء'
      ];
      return $prayer_name_ar[$prayer_name];

    }

  
  }
  