<?php

class PrayerTimes {

    public function __construct() {

      $time = time();
     
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
      // get current hijr date
      $this->current_hijr_date = $current_hijr_date;

      // this site link
      $this->site_link = 'www.salafidemontreal.com';
    }
  
    public function get_months($month_number){
  
      switch ($month_number) {
        case 1:
          $month_name = ['en' => 'January', 'ar' => 'يناير', 'fr' => 'Janvier'];
          break;
        case 2:
          $month_name = ['en' => 'February', 'ar' => 'فبراير', 'fr' => 'Février'];
          break;
        case 3:
          $month_name = ['en' => 'March', 'ar' => 'مارس', 'fr' => 'Mars'];
          break;
        case 4:
          $month_name = ['en' => 'April', 'ar' => 'أبريل', 'fr' => 'Avril'];
          break;
        case 5:
          $month_name = ['en' => 'May', 'ar' => 'مايو', 'fr' => 'Mai'];
          break;
        case 6:
          $month_name = ['en' => 'June', 'ar' => 'يونيو', 'fr' => 'Juin'];
          break;
        case 7:
          $month_name = ['en' => 'July', 'ar' => 'يوليو', 'fr' => 'Juillet'];
          break;
        case 8:
          $month_name = ['en' => 'August', 'ar' => 'أغسطس', 'fr' => 'Août'];
          break;
        case 9:
          $month_name = ['en' => 'September', 'ar' => 'سبتمبر', 'fr' => 'Septembre'];
          break;
        case 10:
          $month_name = ['en' => 'October', 'ar' => 'أكتوبر', 'fr' => 'Octobre'];
          break;
        case 11:
          $month_name = ['en' => 'November', 'ar' => 'نوفمبر', 'fr' => 'Novembre'];
          break;
        case 12:
          $month_name = ['en' => 'December', 'ar' => 'ديسمبر', 'fr' => 'Décembre'];
          break;
        default:
          $month_name = ['en' => '', 'ar' => ''];
          break;
      }
           
        return $month_name;
         
    }
  
      public function timesheaders() {
          $prayer_times = array(
              'Fajr' => [
                          'name' =>['en' => 'Fajr', 'ar' => 'الفجر'],
                          'Athan' => ['time' => '5:00 AM'],
                          'Iqamah' => ['time' => '12:00 PM'],
                        ],
              'Sunrise' => [
                          'name' =>['en' => 'Sunrise','ar' => 'الشروق'],
                          'time' => '6:00 AM',
                        ],
              'Dhuhr' => [
                          'name' =>['en' => 'Dhuhr','ar' => 'الظهر'],
                          'Athan' => ['time' => '5:00 AM'],
                          'Iqamah' => ['time' => '12:00 PM'],
                        ],
              'Asr' => [
                          'name' =>['en' => 'Asr','ar' => 'العصر'],
                          'Athan' => ['time' => '5:00 AM'],
                          'Iqamah' => ['time' => '12:00 PM'],
                        ],
              'Maghrib' => [
                          'name' =>['en' => 'Maghrib','ar' => 'المغرب'],
                          'Athan' => ['time' => '5:00 AM'],
                          'Iqamah' => ['time' => '12:00 PM'],
                        ],
              'Isha' => [
                          'name' =>['en' => 'Isha','ar' => 'العشاء'],
                          'Athan' => ['time' => '5:00 AM'],
                          'Iqamah' => ['time' => '12:00 PM'],
                        ],
               'Jum\'ah' => [
                          'name' =>['en' => 'Jum\'ah','ar' => 'الجمعة'],
                          'Athan' => ['time' => '5:00 AM'],
                          'Iqamah' => ['time' => '12:00 PM'],
                        ],
              
          );
          return $prayer_times;
              
      }
  
      // get prayer name, Athan Iqamah and time
      public function get_prayer_times($prayer_times) {
          $prayer_times_array = array();
          foreach ($prayer_times as $key => $value) {
              $prayer_times_array[$key] = $value['name'];
              $prayer_times_array[$key]['Athan'] = $this->azan_name;
              $prayer_times_array[$key]['Athan_time'] = $value['Athan']['time'];
              $prayer_times_array[$key]['Iqamah'] = $this->iqamah_name;
              $prayer_times_array[$key]['Iqamah_time'] = $value['Iqamah']['time'];
          }
          return $prayer_times_array;
      }
      
      
  }
  