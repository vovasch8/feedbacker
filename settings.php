<?php
session_start();
if((!$_SESSION['is_logged']) || ($_SESSION['user_role'] !== 10)) 
{
	echo "Доступ запрещен!";
	exit;
}

require_once('../../../config.php');

spl_autoload_register(function ($class_name) {
    include '../../../../vendor/my_class/'.$class_name . '.php';
});

echo '<h2   class="mr2">Настройки и инструменты</h2>';

?>
<div class="row">
<div class="col-sm-5 border_right">
<p class="mb05"><b>Ручное создание шаблонов смены</b></p>
<input  data-department="" title="Выбор даты" type="text" id="generate_shedule" class="datepicker"  />
<button class="btn btn-primary mb2px" onclick="">Генерировать</button>

<hr>
<p class="mb05"><b>Ручное обновление пробега GPS по дате</b></p>



<div class="input-group mb-3 ">
  <div class="input-group-prepend">
    <label class="input-group-text label_for_input" for="inputGroupSelect01">График работы</label>
  </div>
  <select class="custom-select" id="departments_shedule_select" name="departments_shedule">
  <?php	
$departmentshedules = (new DB())->getDepartmentShedules();	

foreach($departmentshedules as $departmentshedule)
{
	?>
	<option value="<?php echo $departmentshedule['id'];  ?>"> <?php echo $departmentshedule['name'];  ?></option>
	<?php	
}
?>
 </select>
</div>



<input  data-department="" title="Выбор даты" type="text" id="gps_shedule" class="datepicker"  />


<button class="btn btn-primary mb2px" onclick="">Обновить</button>

<hr>
<p class="mb05"><b>Ручное обновление данных по заправкам</b></p>
<input  data-department="" title="Выбор даты" type="text" id="socar_shedule" class="datepicker"  />
<button class="btn btn-primary mb2px" onclick="updateSocar('admin/settings/update_socar', document.getElementById('socar_shedule').value)">Обновить</button>

<hr>
<p class="mb05"><b>Просмотр данных по заправкам</b></p>
<input  data-department="" title="Выбор даты" type="text" id="socar_history" class="datepicker"  />
<button class="btn btn-primary mb2px" onclick="historySocar('admin/settings/history_socar', document.getElementById('socar_history').value)">Загрузить</button>
<hr>


<p class="mb05"><b>Загрузка данных по Uklon</b></p>

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text label_for_input" for="inputGroupSelect01">Филиал</label>
  </div>
  <select class="custom-select" id="department_id_uklon_update" name="department_id_uklon_update">
  	<?php	
	$departments = (new DB())->getAllDepartments();
	foreach($departments as $department)
	{
	?>
	<option value="<?php echo $department['id'];  ?>"><?php echo $department['name'];  ?></option>
	<?php	
}
?>



 </select>
</div>

<input  data-department="" title="Выбор даты" type="text" id="update_uklon" class="datepicker"  />
<button class="btn btn-primary mb2px" onclick="">Обновить</button>
<hr>




<!--
<p class="mb05"><b>Просмотр данных по Uklon</b></p>

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text label_for_input" for="inputGroupSelect01">Филиал</label>
  </div>
  <select class="custom-select" id="department_id_uklon" name="department_id_uklon">
  	<?php	
	$departments = (new DB())->getAllDepartments();
	foreach($departments as $department)
	{
	?>
	<option value="<?php echo $department['id'];  ?>"><?php echo $department['name'];  ?></option>
	<?php	
}
?>



 </select>
</div>

<input  data-department="" title="Выбор даты" type="text" id="uklon_history" class="datepicker"  />
<button class="btn btn-primary mb2px" onclick="historyUklon('admin/settings/uklon_history', document.getElementById('uklon_history').value)">Загрузить</button>
<hr>
-->

<a href="https://peresmenka.softko.net/www/templates/admin/settings/wialon_id.php" target="_blank">Wialon ID</a>

</div>
<div class="col-sm-7">
<div class="pb2" id="info_container"></div>
</div></div>
