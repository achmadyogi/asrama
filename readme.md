<h1>Dormitory Project</h1>
<h2>Setelah melakukan clone lakukan langkah berikut ini</h2>
<ul>
  <li>Clone your project</li>
  <li>Go to the folder application using cd</li>
  <li>Run composer install on your cmd or terminal</li>
  <li>Copy .env.example file to .env on root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal Ubuntu</li>
  <li>Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.</li> 
  <li>By default, username is root and you can leave password field empty. (This is for Xampp)</li> 
  <li>By default, username is root and password is also root. (This is for Lamp)</li>
  <li>Run php artisan key:generate</li>
  <li>Run php artisan migrate</li>
  <li>Run php artisan serve</li>
  <li>Go to localhost:8000</li>
</ul>
<h2>Jika mendapat error = "Failed to parse time string (2018-03-10 13:08:09.-708656) at position 24 (6): Unexpected character
"</h2>
<ul>
  <li>download carbon.zip pada repository</li>
  <li>extract carbon.zip</li>
  <li>copy paste folder carbon kedalam YourProject/vendor/nesbot/</li>
  <li>Replace</li>
</ul>
"# asrama"
