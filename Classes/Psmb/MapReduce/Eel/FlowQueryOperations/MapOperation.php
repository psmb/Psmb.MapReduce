<?php
namespace Psmb\MapReduce\Eel\FlowQueryOperations;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\FlowQuery\Operations\AbstractOperation;
use Neos\ContentRepository\Domain\Model\NodeInterface;

/**
 * Map Operation
 *
 * Takes an Eel Expression as a first argument and maps it to every context variable.
 * Current value is injected as `value` context variable.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/map
 */
class MapOperation extends AbstractOperation {
	/**
	 * {@inheritdoc}
	 *
	 * @var string
	 */
	static protected $shortName = 'map';

	/**
	 * {@inheritdoc}
	 *
	 * @var integer
	 */
	static protected $priority = 100;

	/**
	 * {@inheritdoc}
	 *
	 * @var boolean
	 */
	static protected $final = TRUE;

	/**
	 * {@inheritdoc}
	 *
	 * @param array (or array-like object) $context onto which this operation should be applied
	 * @return boolean TRUE if the operation can be applied onto the $context, FALSE otherwise
	 */
	public function canEvaluate($context) {
		return isset($context[0]);
	}

	/**
	 * @Flow\Inject
	 * @var \Neos\Eel\EelEvaluatorInterface
	 */
	protected $eelEvaluator;

	/**
	 * {@inheritdoc}
	 *
	 * @param \Neos\Eel\FlowQuery\FlowQuery $flowQuery
	 * @param array $arguments
	 * @return void
	 */
	public function evaluate(\Neos\Eel\FlowQuery\FlowQuery $flowQuery, array $arguments) {
		if (!isset($arguments[0]) || empty($arguments[0])) {
			throw new \Neos\Eel\FlowQuery\FlowQueryException('No Eel expression provided', 1332492243);
		}
		$expression = '${' . $arguments[0] . '}';
		$context = $flowQuery->getContext();

		return array_map(
			function ($value) use ($expression, $context) {
				return \Neos\Eel\Utility::evaluateEelExpression($expression, $this->eelEvaluator, array('value' => $value));
			},
			$context
		);
	}
}
