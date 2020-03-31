
<?php
session_start();

// $operatorArray = array(
//   "+" => "add",
//   "-" => "sub",
//   "*" => "mult",
//   "/" => "div",
//   "x^y" => "pow"
// );


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
if (isset($_POST["operator"])) {
  $operator = $_POST["operator"];
}
else {
  $operator = "";
}


// functions to validate input
// trim() -- entfernt whitespaces
// intval() -- wandelt in Zahl um
// floatval() -- wandelt in Zahl um
// is_int()
// is_float()
// is_numeric() -- ueberpruft ob Wert numerisch ist


$ergebnis = 0;
if (isset($_POST["submit"]))
  switch ($_POST["submit"]) {
    case "berechnen":
      // calculate
      if (trim($operand1 == "") || trim($operand2 == "")) {
        echo "input incorrect!";
        break;
      }
      switch ($operator) {
        case "+":
          $ergebnis = $operand1 + $operand2;
          break;
        case "-":
          $ergebnis = $operand1 - $operand2;
          break;
        case "*":
          $ergebnis = $operand1 * $operand2;
          break;
        case "/":
          if ($operand2 == 0)
            echo "Op2 darf nicht 0 sein!";
          else
            $ergebnis = $operand1 / $operand2;
          break;

        case "x^y":
          if ($operand1 == 0 && $operand2 == 0)
            echo "0^0 ist nicht definiert";
          else
            $ergebnis = pow($operand1, $operand2);
          break;
      }

      // result history
      if (isset($_SESSION["resultHistory"])) {
        $_SESSION["resultHistory"][] = $ergebnis;
      }
      else {
        $_SESSION["resultHistory"] = array($ergebnis);
      }
      break;


    case "memory_set":
      if (trim($_POST["ergebnis"]) == "")
        break;
      $_SESSION["memory"] = $_POST["ergebnis"];
      $ergebnis = $_POST["ergebnis"];
      break;
    case "memory_read":
      $operand1 = $_SESSION["memory"];
      break;
    case "clear_results":
      unset($_SESSION["resultHistory"]);
      // intentional fallthrough
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

  <form id="taschenrechner"
  name="taschenrechner" method="POST">
  <table>
    <tr>
      <td colspan="4">
        <select name="resultHistory" multiple>
          <!-- here goes php -->
          <!-- wenn wir berechnen, speichern wir das neue Ergebnis in einer Liste -->
          <!-- hier geben wir die Liste aus -->
          <?php
            if (isset($_SESSION["resultHistory"]))
              foreach ($_SESSION["resultHistory"] as $result) {
                echo "<option>".$result."</option>";
              }
          ?>
        </select>
      </td>
    </tr>

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
      <td>
        <select name="operator">
          <?php
            foreach(array("+", "-", "*", "/", "x^y") as $op) {
              echo "<option value=$op ";
              if ($op == $operator)
                echo 'selected="true"';
              echo ">$op</option>";
            }
          ?>
          <!-- <option value="+">+</option>
          <option value="-">-</option>
          <option value="*">*</option>
          <option value="/">/</option>
          <option value="x^y">x^y</option> -->
        </select>
    </td>
      <td>
        <input type="number" name="op2" value="<?php echo $operand2 ?>">
      </td>
      <td>
        =
        <input  readonly
                type="number" name="ergebnis" value= "<?php echo $ergebnis ?>">
      </td>
    </tr>
  </table>

    <button form="taschenrechner"
            type="submit" value="berechnen" name="submit">
      Berechnen
    </button>
    <br>
    <!-- eigentlich sollte man das so machen -->
    <!-- <input type="reset" value="C" name="reset"> -->
    <button form="taschenrechner"
            type="submit" value="reset" name="submit">
      C
    </button>
    <br>
    <button form="taschenrechner"
            type="submit" value="clear_results" name="submit">
      RC
    </button>
    <br>
    <button form="taschenrechner"
            type="submit" value="memory_set" name="submit">
      M+
    </button>
    <br>
    <button form="taschenrechner"
            type="submit" value="memory_read" name="submit">
      MR
    </button>
  </form>
</body>
</html>