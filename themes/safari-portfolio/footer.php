  <div id="firefliesContainer" aria-hidden="true"></div>

  <!-- Audio (ambient + shutter for game) -->
  <audio id="ambientAudio" loop>
    <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/audio/ambient-safari.mp3' ); ?>" type="audio/mpeg">
  </audio>
  <audio id="shutterAudio">
    <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/audio/shutter.mp3' ); ?>" type="audio/mpeg">
  </audio>

  <?php wp_footer(); ?>
</body>
</html>
