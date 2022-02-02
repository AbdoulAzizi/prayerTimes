<?php
setlocale(LC_TIME, 'fr_FR.utf8','fra'); 

$classes = ['PrayerTimes', 'prayTimes'];

// include classes
foreach ($classes as $class) {
  require_once 'classes/' . $class . '.php';
}
require_once 'Date.php';
?>
<style>
<?php include 'css/style.css'; ?>
</style>
<table class="prayer_time">
  <?php $prayertimes = new PrayerTimes(); ?>
  <?php $current_prayer_name = strtolower($prayertimes->current_prayer['name']); ?>
    <tr>
     <td class="flip-card-outer" colspan="4">
          <div class="flip-card">
              <div class="flip-card-inner">
                  <div class="flip-card-front">
                      <span class="arabic_text"><?php echo $prayertimes->get_masjid_name(); ?></span><br>
                      <div class="time_now"><span><?php echo date('h:i', $prayertimes->current_time) . ' ' ?></span><?php echo date('A', $prayertimes->current_time); ?></div>
                      <span class="date"><?php echo ucfirst(strftime("%A")) . ' ' . date('d', $prayertimes->current_time) . ' ' . $prayertimes->get_months(date('m', $prayertimes->current_time))['fr']; ?>  <span class="arabic_text"> <?php echo '('.$prayertimes->get_months(date('m', $prayertimes->current_time))['ar'].') '; ?></span><?php echo date('Y', $prayertimes->current_time); ?></span><br>
                      <span class="date"><?php echo $prayertimes->current_hijr_date; ?></span>
                  </div>
                  <div class="flip-card-back">
                      <span class="arabic_text"><?php echo $prayertimes->get_masjid_name(); ?></span><br>
                      <div class="time_now_text"><span>Iqama temps de prière  <?php echo ucfirst($current_prayer_name); ?></span></div>
                      <span class="date"><?php echo date('d', $prayertimes->time) . ' ' . $prayertimes->get_months(date('m', $prayertimes->time))['fr']; ?>  <span class="arabic_text"> <?php echo '('.$prayertimes->get_months(date('m', $prayertimes->time))['ar'].'), '; ?></span><?php echo date('Y', $prayertimes->time); ?></span><br>
                          <span class="date"><?php echo $prayertimes->current_hijr_date; ?></span>
                      </div>
                  </div>
              </div>
    </td>

    <td class="flip-card-outer" colspan="4">
    <div class="flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front">

                <span class="arabic_text">Copyright &#169; 2022 Mosque prayer Times All rights reserved<br><br>
                <span class="time_now_right"><?php echo $prayertimes->current_prayer['name'] . ' ('.$prayertimes->get_prayer_name_ar($current_prayer_name).')'; ?></span><br>
                <table class="prayer_time_now">
                    <tr>
                        <td class="prayer_time_now_right_label"><?php echo $prayertimes->get_azan_name(); ?></td>
                        <td class="prayer_time_now_right"><?php echo $prayertimes->current_prayer['time']; ?></td>
                    </tr>

                    <tr>
                        <td class="prayer_time_now_right_label"><?php echo $prayertimes->get_iqamah_name(); ?></td>
                        <td class="prayer_time_now_right"><?php echo $prayertimes->current_prayer['iqamah']; ?></td>
                    </tr>

                </table>
                <span class="link"><?php echo $prayertimes->site_link; ?></span>
            </div>
            <div class="flip-card-back">
                <span class="arabic_text">Copyright &#169; 2022 Mosque prayer Times All rights reserved<br><br>
                <span class="time_now_right"><?php echo $prayertimes->current_prayer['name'] . ' ('.$prayertimes->get_prayer_name_ar($current_prayer_name).')'; ?></span><br>
                <div class="time_now_text"><span>وقت إقامة الصلاة <?php echo $prayertimes->get_prayer_name_ar($current_prayer_name); ?></div><br>
                      <span class="link"><?php echo $prayertimes->site_link; ?></span>
                </div>
            </div>
        </div>
    </td>
    </tr>

    <tr>
            <td></td>
            <td class="bottom_label">Fajr <span class="arabic_text">(الفجر)</span></td>
            <td class="bottom_label">Shurooq <span class="arabic_text">(الشروق)</span></td>
            <td class="bottom_label">Zuhr <span class="arabic_text">(الظهر)</span></td>
            <td class="bottom_label">Asr <span class="arabic_text">(العصر)</span></td>
            <td class="bottom_label">Maghreb <span class="arabic_text">(المغرب)</span></td>
            <td class="bottom_label">Isha <span class="arabic_text">(العشاء)</span></td>
            <td class="bottom_label">Jum'ah <span class="arabic_text">(الجمعة)</span></td>
        </tr>
        <tr>
            <td class="bottom_label bottom_label_time">Azan <span class="arabic_text">(الأذان)</span></td>
            <td class="bottom_label bottom_label_time"><?php echo $prayertimes->get_prayer_time('fajr'); ?></td>
            <td class="bottom_label bottom_label_time" rowspan="2"><?php echo $prayertimes->get_prayer_time('sunrise'); ?></td>
            <td class="bottom_label bottom_label_time"><?php echo $prayertimes->get_prayer_time('zuhr'); ?></td>
            <td class="bottom_label bottom_label_time"><?php echo $prayertimes->get_prayer_time('asr'); ?></td>
            <td class="bottom_label bottom_label_time"><?php echo $prayertimes->get_prayer_time('maghrib'); ?></td>
            <td class="bottom_label bottom_label_time"><?php echo $prayertimes->get_prayer_time('isha'); ?></td>
            <td class="bottom_label bottom_label_time" rowspan="2">
                <span class="small_text_one">Khutbah <span class="arabic_text">(الخطبة)</span></span><br> <?php echo $prayertimes->get_prayer_time('zuhr'); ?>
            </td>
        </tr>
        <tr>
            <td class="bottom_label bottom_label_time iqamah">Iqama <span class="arabic text">(الإقامة)</span></td>
            <td class="bottom_label bottom_label_time iqamah"><?php echo $prayertimes->get_iqamah_time('fajr'); ?></td>
            <td class="bottom_label bottom_label_time iqamah"><?php echo $prayertimes->get_iqamah_time('zuhr'); ?></td>
            <td class="bottom_label bottom_label_time iqamah"><?php echo $prayertimes->get_iqamah_time('asr'); ?></td>
            <td class="bottom_label bottom_label_time iqamah"><?php echo $prayertimes->get_iqamah_time('maghrib'); ?></td>
            <td class="bottom_label bottom_label_time iqamah"><?php echo $prayertimes->get_iqamah_time('isha'); ?></td>
        </tr>
        
</table>

<script>
   // add active class to current prayer
    var current_prayer_time = '<?php echo $prayertimes->current_prayer['time']; ?>';
    var current_prayer_iqamah = '<?php echo $prayertimes->current_prayer['iqamah']; ?>';

    // get value of each bottom_label_time class with javascript
    var bottom_label_time = document.getElementsByClassName('bottom_label_time');

    // loop through each bottom_label_time class
    for (var i = 0; i < bottom_label_time.length; i++) {
        // if current prayer time is equal to bottom_label_time class value
        if (current_prayer_time == bottom_label_time[i].innerHTML) {
            // add active class to bottom_label_time class
            bottom_label_time[i].classList.add('bottom_label_time_active');
        }
    }
    
    // add active class the iqama time
    var bottom_label_time_iqamah = document.getElementsByClassName('iqamah');

    // loop through each bottom_label_time_iqamah class
    for (var i = 0; i < bottom_label_time_iqamah.length; i++) {
        // if current prayer iqamah is equal to bottom_label_time_iqamah class value
        if (current_prayer_iqamah == bottom_label_time_iqamah[i].innerHTML) {
            // add active class to bottom_label_time_iqamah class
            bottom_label_time_iqamah[i].classList.add('bottom_label_time_active');
        }
    }

    // var bottom_label_time = $('.bottom_label_time').val();
    // // doc ready
    // $(document).ready(function(){
    //     // loop through each bottom_label_time class
    //     bottom_label_time.each(function(){
    //         // get value of each bottom_label_time class
    //         var bottom_label_time_value = $(this).text();
    //         // if current prayer time is equal to bottom_label_time value
    //         if(current_prayer_name == bottom_label_time_value){
    //             // add class active
    //             $(this).addClass('bottom_label_time_active');
    //         }
    //     });
    // });

   
   
</script>
