<?php

namespace famima65536\lwe\utils;

interface Policy {
	public function satisfiedBy($object): bool;
}