# ScienceBoilerplate
DoesScience trait handles some of the boilerplate associated with performing experimental code refactoring using Science!

```php

<?php

class myClass
{
  use \thinkspill\DoesScience;
  
  public function main()
  {
    $result = $this->oldCreakyFunction();
  }
  
  // ...
}
```


Lets refactor `oldCreakyFunction` by starting from some boilerplate:


```php

<?php

class myClass
{
  use \thinkspill\DoesScience;
  
  public function main()
  {
    /** boilerplate start */
    $control = function (...$vars) {
        return call_user_func_array([$this, 'oldCreakyMethod'], func_get_args());
    };

    $trial = function (...$vars) {
        return call_user_func_array([$this, 'newShinyMethod'], func_get_args());
    };

    $this->makeScienceExperiment('Experiment Name', $control);
    $this->addExperimentTrial('trial 1', $trial);

    ~r($this->experimentReport($arg1, $arg2));
    /** boilerplate end */

    // $result = $this->oldCreakyFunction($arg1, $arg2);
  }
  
  private function oldCreakyMethod($arg1, $arg2)
  { 
    // ...
  }
  private function newShinyMethod($arg1, $arg2)
  { 
    // ...
  }
}
```

