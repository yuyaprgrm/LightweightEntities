<?php

namespace famima65536\lwe\utils;

interface Policy {
	public function satisfyBy($object): bool;
}