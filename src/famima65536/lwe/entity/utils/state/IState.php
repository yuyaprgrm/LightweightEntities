<?php

namespace famima65536\lwe\entity\utils\state;

interface IState {
	public function getId(): int;
	public function isFinished(): bool;
	public function decreaseTime(int $tick);
}