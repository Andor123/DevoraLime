<?php
// Általános hős osztály
abstract class Hero {
    protected $id;
    protected $type;
    protected $health;
    protected $maxHealth;

    public function __construct($id, $type, $health) {
        $this->id = $id;
        $this->type = $type;
        $this->health = $health;
        $this->maxHealth = $health;
    }

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getHealth() {
        return $this->health;
    }

    public function getMaxHealth() {
        return $this->maxHealth;
    }

    public function setHealth($health) {
        $this->health = $health;
    }

    public function isAlive() {
        return $this->health > 0;
    }

    public function takeDamage($damage) {
        $this->health -= $damage;
        if ($this->health < 0) {
            $this->health = 0;
        }
    }

    public function heal($amount) {
        $this->health += $amount;
        if ($this->health > $this->maxHealth) {
            $this->health = $this->maxHealth;
        }
    }

    abstract public function attack(Hero $target);

    abstract public function defend(Hero $attacker);
}

//Íjász osztály
class Archer extends Hero {
    public function __construct($id) {
        parent::__construct($id, "Archer", 100);
    }

    public function attack(Hero $target) {
        $randomChance = rand(1, 100);

        if ($target instanceof Horseman) {
            if ($randomChance <= 40) {
                $target->takeDamage($this->calculateDamage());
                return "{$this->type} attacked {$target->getType()} and caused damage.";
            } else {
                return "{$this->type} tried to attack {$target->getType()} but it was defended.";
            }
        } elseif ($target instanceof Swordsman) {
            $target->takeDamage($this->calculateDamage());
            return "{$this->type} attacked {$target->getType()} and caused damage.";
        } elseif($target instanceof Archer) {
            $target->takeDamage($this->calculateDamage());
            return "{$this->type} attacked {$target->getType()} and caused damage.";
        }
        
        return "{$this->type} couldn't attack {$target->getType()}.";
    }

    public function defend(Hero $attacker) {
        if ($attacker instanceof Horseman) {
            $this->takeDamage($this->calculateDamage());
            return "{$this->type} tried to defend against {$attacker->getType()} but died.";
        } elseif ($attacker instanceof Swordsman) {
            return "{$this->type} defended against {$attacker->getType()}.";
        } elseif ($attacker instanceof Archer) {
            $this->takeDamage($this->calculateDamage());
            return "{$this->type} tried to defend against {$attacker->getType()} but died.";
        }
        
        return "{$this->type} couldn't defend against {$attacker->getType()}.";
    }

    public function calculateDamage() {
        return rand(10, 20);
    }
}

//Lovas osztály
class Horseman extends Hero {
    public function __construct($id) {
        parent::__construct($id, "Horseman", 150);
    }

    public function attack(Hero $target) {
        if ($target instanceof Archer) {
            $target->takeDamage($this->calculateDamage());
            return "{$this->type} attacked {$target->getType()} and caused damage.";
        } elseif ($target instanceof Swordsman) {
            return "{$this->type} attacked {$target->getType()} but nothing happened.";
        } elseif ($target instanceof Horseman) {
            return "{$this->type} attacked {$target->getType()} but nothing happened.";
        }
        
        return "{$this->type} couldn't attack {$target->getType()}.";
    }

    public function defend(Hero $attacker) {
        return "{$this->type} defended against {$attacker->getType()}.";
    }

    public function calculateDamage() {
        return rand(20, 30);
    }
}

//Kardos osztály
class Swordsman extends Hero {
    public function __construct($id) {
        parent::__construct($id, "Swordsman", 120);
    }

    public function attack(Hero $target) {
        if ($target instanceof Archer) {
            return "{$this->type} attacked {$target->getType()} but nothing happened.";
        } elseif ($target instanceof Swordsman) {
            return "{$this->type} attacked {$target->getType()} but nothing happened.";
        } elseif ($target instanceof Horseman) {
            $target->takeDamage($this->calculateDamage());
            return "{$this->type} attacked {$target->getType()} and caused damage.";
        }
        
        return "{$this->type} couldn't attack {$target->getType()}.";
    }

    public function defend(Hero $attacker) {
        if ($attacker instanceof Horseman) {
            $this->takeDamage($this->calculateDamage());
            return "{$this->type} tried to defend against {$attacker->getType()} but died.";
        } elseif ($attacker instanceof Swordsman) {
            return "{$this->type} defended against {$attacker->getType()}.";
        } elseif ($attacker instanceof Archer) {
            $this->takeDamage($this->calculateDamage());
            return "{$this->type} tried to defend against {$attacker->getType()} but died.";
        }
        
        return "{$this->type} couldn't defend against {$attacker->getType()}.";
    }

    public function calculateDamage() {
        return rand(15, 25);
    }
}
?>