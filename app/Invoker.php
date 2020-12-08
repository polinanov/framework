<?php

declare(strict_types = 1);

class Invoker
{
    public function action(ICommand $command) {
        return $command->execute();
    }
}
