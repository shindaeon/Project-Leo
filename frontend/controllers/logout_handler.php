<?php
try {
      session_start();
      session_unset();
      session_destroy();
      echo 'success';
} catch (Exception $e) {
      echo 'error';
      echo `
            <script>
                  console.log('Error:` . $e . `);
            </script>
            `;
}
