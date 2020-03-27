
<?php
if (isset($_POST["op1"])) {
    $operater1 = $_POST["op1"];
}
else {
    $operater1 = 0;
}
if (isset($_POST["op2"])) {
    $operater2 = $_POST["op2"];
}
else {
    $operater2 = 0;
}

$ergebnis = $operater1 + $operater2;

?>

<html>
<body>
  <title>Gustavs toller Taschenrechner</title>

  <!-- "style" zeug ist CSS und muss uns jetzt noch nicht interessieren -->
  <h1 style="text-align: center;">
    Taschenrechner
  </h1>

  <form name="taschenrechner" method="POST">
  <table>
    <tr>
      <td>Operand 1</td>
      <td>Operator</td>
      <td>Operand 2</td>
      <td>Ergebnis</td>
    </tr>

    <tr>
      <td>
        <input type="number" name="op1" value="<?php echo $operater1 ?>">
      </td>
      <td> + </td>
      <td>
        <input type="number" name="op2" value="<?php echo $operater2 ?>">
      </td>
      <td>
        =
        <input type="number" name="ergebnis" value= "<?php echo $ergebnis ?>">
      </td>
    </tr>
  </table>

    <button type="submit" value="berechnen" name="berechnen">
      Berechnen
    </button>
  </form>
</body>
</html>