<?php

namespace famima65536\lwe\entity\behavior\spawnRules\component;

interface IConditionComponent {
	/**
	 * return name of component like minecraft:spawns_underwater
	 * @return string
	 */
	public function getName(): string;
}