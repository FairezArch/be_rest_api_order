<?php

# Question 1

# Input: ​[“AB”, [“XY”], [“YP”]], ‘Y’ Output: ​4
# Input: ​[“”, [“”, [“XXXXX”]]], ‘X’ Output: ​3
# Input: ​[“X”], ‘X’ Output: ​1
# Input: ​[“”], ‘X’ Output: 0
# Input: ​[“X”, [“”, [“”, [“Y”], [“X”]]], [“X”, [“”, [“Y”], [“Z”]]]], ‘X’ Output: ​7
# Input: ​[“X”, [“”], [“X”], [“X”], [“Y”, [“”]], [“X”]], ‘X’ Output: ​7
# Input: ​[“ABAH”, [“CIRCA”], [“CRUMP”, [“IRA”]], [“ALI”]], “ACI” Output: ​37

# Answer

function sum_deep($arr, $str, $tree = 1)
{
    $sum = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];
        foreach ($arr as $node) {
            if (is_string($node)) {
                if (strpos($node, $char) !== false) {
                    $sum += $tree * ($i + 1);
                }
            } else {
                $sum += sum_deep($node, $char, $tree + 1) * ($i + 1);
            }
        }
    }
    return $sum;
}

echo "Question 1" . "\n";

echo sum_deep(["AB", ["XY"], ["YP"]], 'Y') . "\n";
echo sum_deep(["", ["", ["XXXXX"]]], 'X') . "\n";
echo sum_deep(["X"], 'X') . "\n";
echo sum_deep([""], 'X') . "\n";
echo sum_deep(["X", ["", ["", ["Y"], ["X"]]], ["X", ["", ["Y"], ["Z"]]]], 'X') . "\n";
echo sum_deep(["X", [""], ["X"], ["X"], ["Y", [""]], ["X"]], 'X') . "\n";
echo sum_deep(["ABAH", ["CIRCA"], ["CRUMP", ["IRA"]], ["ALI"]], "ACI") . "\n";

echo "==================================================" . "\n";

# Question 3

# Input:​“palindrom”, “ind”
# Output: ​1
# Input: ​“abakadabra”, “ab”
# Output: ​2
# Input: ​“hello”,
# “” Output: ​0
# Input: ​“ababab”, “aba”
# Output: ​2
# Input: ​“aaaaaa”, “aa”
# Output: ​5
# Input: ​“hell”, “hello”
# Output: ​0

# Answer

function pattern_count($text, $pattern)
{
    $text_len = strlen($text);
    $pattern_len = strlen($pattern);
    $count = 0;
    // return $pattern_len;

    for ($i = 0; $i < $text_len - $pattern_len + 1; $i++) {
        $match = true;
        for ($j = 0; $j < $pattern_len; $j++) {
            if ($text[$i + $j] != $pattern[$j]) {
                $match = false;
                break;
            }
        }
        if ($match) {
            $count++;
        }
    }

    return $count;
}

echo "Question 3" . "\n";

echo pattern_count("palindrom", "ind") . "\n";
echo pattern_count("abakadabra", "ab") . "\n";
echo pattern_count("hello", "") . "\n";
echo pattern_count("ababab", "aba") . "\n";
echo pattern_count("aaaaaa", "aa") . "\n";
echo pattern_count("hell", "hello") . "\n";

echo "==================================================" . "\n";

echo "Question 4" . "\n";
// abstract ship class
abstract class Ship {
    protected $name;
    protected $length;
    protected $weight;
    
    public function __construct($name, $length, $weight) {
        $this->name = $name;
        $this->length = $length;
        $this->weight = $weight;
    }
    
    abstract public function getType();
    
    public function getInfo() {
        return "Name: " . $this->name . ", Length: " . $this->length . ", Weight: " . $this->weight;
    }
}

// motor boat class
class MotorBoat extends Ship {
    private $engineType;
    
    public function __construct($name, $length, $weight, $engineType) {
        parent::__construct($name, $length, $weight);
        $this->engineType = $engineType;
    }
    
    public function getType() {
        return "Motor Boat";
    }
    
    public function getInfo() {
        return parent::getInfo() . ", Engine Type: " . $this->engineType;
    }
}

// sailboat class
class Sailboat extends Ship {
    private $sailCount;
    
    public function __construct($name, $length, $weight, $sailCount) {
        parent::__construct($name, $length, $weight);
        $this->sailCount = $sailCount;
    }
    
    public function getType() {
        return "Sailboat";
    }
    
    public function getInfo() {
        return parent::getInfo() . ", Sail Count: " . $this->sailCount;
    }
}

// yacht class
class Yacht extends Ship {
    private $cabinCount;
    
    public function __construct($name, $length, $weight, $cabinCount) {
        parent::__construct($name, $length, $weight);
        $this->cabinCount = $cabinCount;
    }
    
    public function getType() {
        return "Yacht";
    }
    
    public function getInfo() {
        return parent::getInfo() . ", Cabin Count: " . $this->cabinCount;
    }
}

$motorBoat = new MotorBoat("Sea Runner", 10, 5000, "Diesel");
echo $motorBoat->getType() . ": " . $motorBoat->getInfo() . "\n";

$sailboat = new Sailboat("Wind Chaser", 15, 10000, 3);
echo $sailboat->getType() . ": " . $sailboat->getInfo() . "\n";

$yacht = new Yacht("Ocean Blue", 20, 20000, 4);
echo $yacht->getType() . ": " . $yacht->getInfo() . "\n";

