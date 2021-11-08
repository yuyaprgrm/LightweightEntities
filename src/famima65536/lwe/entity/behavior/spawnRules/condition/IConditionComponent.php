<?php

namespace famima65536\lwe\entity\behavior\spawnRules\condition;

interface IConditionComponent {
	/**
	 * @return string like minecraft:spawns_underwater
	 */
	public function getName(): string;
}