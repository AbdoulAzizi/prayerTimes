<?php
setlocale(LC_TIME, 'fr_FR.utf8','fra'); 

$classes = ['PrayerTimes', 'Arabic'];

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
  <?php $prayer_times = $prayertimes->timesheaders(); ?>
  <?php $prayer_times_array = $prayertimes->get_prayer_times($prayer_times); ?>

    <tr>
     <td class="flip-card-outer" colspan="4">
          <div class="flip-card">
              <div class="flip-card-inner">
                  <div class="flip-card-front">
                      <span class="arabic_text"><?php echo $prayertimes->majid_name; ?></span><br>
                      <div class="time_now"><span><?php echo date('h:i', $prayertimes->time) . ' ' ?></span><?php echo date('A', $prayertimes->time); ?></div>
                      <span class="date"><?php echo ucfirst(strftime("%A")) . ' ' . date('d', $prayertimes->time) . ' ' . $prayertimes->get_months(date('m', $prayertimes->time))['fr']; ?>  <span class="arabic_text"> <?php echo '('.$prayertimes->get_months(date('m', $prayertimes->time))['ar'].') '; ?></span><?php echo date('Y', $prayertimes->time); ?></span><br>
                      <span class="date"><?php echo $prayertimes->current_hijr_date; ?></span>
                  </div>
                  <div class="flip-card-back">
                      <span class="arabic_text"><?php echo $prayertimes->majid_name; ?></span><br>
                      <div class="time_now_text"><span>iqama temps de prière zuhr</div><br>
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
                <span class="time_now_right">Asr <span class="arabic_text">(العصر)</span></span><br>
                <table class="prayer_time_now">
                    <tr>
                        <td class="prayer_time_now_right_label"><?php echo $prayertimes->azan_name; ?></td>
                        <td class="prayer_time_now_right">2:23</td>
                    </tr>

                    <tr>
                        <td class="prayer_time_now_right_label"><?php echo $prayertimes->iqamah_name; ?></td>
                        <td class="prayer_time_now_right">3:00</td>
                    </tr>

                </table>
                <span class="link"><?php echo $prayertimes->site_link; ?></span>
            </div>
            <div class="flip-card-back">
                <span class="arabic_text">Copyright &#169; 2022 Mosque prayer Times All rights reserved<br><br>
                <span class="time_now_right">Asr <span class="arabic_text">(العصر)</span></span><br>
                <div class="time_now_text"><span>وقت إقامة الصلاة الظهر</div><br>
                      <span class="link"><?php echo $prayertimes->site_link; ?></span>
                </div>
            </div>
        </div>
    </td>
    </tr>

    <tr>
        <td></td>
        <?php foreach ($prayer_times_array as $key => $value) { 
          echo '<td>'.$value['en'].'('.$value['ar'].')</td>';
        } ?>
      </tr>
      <tr>
        <td><?php echo $prayertimes->azan_name; ?></td>
        <?php foreach ($prayer_times_array as $key => $value) { 
          echo '<td>'.$value['Athan_time'].'</td>';
        } ?>
      </tr>
      <tr>
        <td><?php echo $prayertimes->iqamah_name; ?></td>
        <?php foreach ($prayer_times_array as $key => $value) { 
          echo '<td>'.$value['Iqamah_time'].'</td>';
        } ?>
    </tr>
        
</table>

