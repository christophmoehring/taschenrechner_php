
<?php
session_start();

if (isset($_POST["op1"])) {
    $operand1 = $_POST["op1"];
}
else {
    $operand1 = 0;
}
if (isset($_POST["op2"])) {
    $operand2 = $_POST["op2"];
}
else {
    $operand2 = 0;
}

$ergebnis = 0;
if (isset($_POST["submit"]))
  switch ($_POST["submit"]) {
    case "berechnen":
      $ergebnis = $operand1 + $operand2;
      break;
    case "memory_set":
      $_SESSION["memory"] = $_POST["ergebnis"];
      $ergebnis = $_POST["ergebnis"];
      break;
    case "memory_read":
      $operand1 = $_SESSION["memory"];
      break;

    // unschoen, s. unten
    case "reset":
      $operand1 = "";
      $operand2 = "";
      $ergebnis = "";
      break;
  }

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
        <input type="number" name="op1" value="<?php echo $operand1 ?>">
      </td>
      <td> + </td>
      <td>
        <input type="number" name="op2" value="<?php echo $operand2 ?>">
      </td>
      <td>
        =
        <input type="number" name="ergebnis" value= "<?php echo $ergebnis ?>">
      </td>
    </tr>
  </table>

    <button type="submit" value="berechnen" name="submit">
      Berechnen
    </button>
    <br>
    <!-- eigentlich sollte man das so machen -->
    <!-- <input type="reset" value="C" name="reset"> -->
    <button type="submit" value="reset" name="submit">
      C
    </button>
    <br>
    <button type="submit" value="memory_set" name="submit">
      M+
    </button>
    <br>
    <button type="submit" value="memory_read" name="submit">
      MR
    </button>
  </form>
</body>
</html>