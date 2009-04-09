<?php
/**
 * MainMenu is a widget displaying main menu items.
 *
 * The menu items are displayed as an HTML list. One of the items
 * may be set as active, which could add an "active" CSS class to the rendered item.
 *
 * To use this widget, specify the "items" property with an array of
 * the menu items to be displayed. Each item should be an array with
 * the following elements:
 * - visible: boolean, whether this item is visible;
 * - label: string, label of this menu item. Make sure you HTML-encode it if needed;
 * - url: string|array, the URL that this item leads to. Use a string to
 *   represent a static URL, while an array for constructing a dynamic one.
 * - pattern: array, optional. This is used to determine if the item is active.
 *   The first element refers to the route of the request, while the rest
 *   name-value pairs representing the GET parameters to be matched with.
 *   When the route does not contain the action part, it is treated
 *   as a controller ID and will match all actions of the controller.
 *   If pattern is not given, the url array will be used instead.
 */
class TabMenu extends CWidget
{
	public $items=array();

	public function run()
	{

		$items=array();

		$controller=$this->controller;
		$action=$controller->action;

		foreach($this->items as $item)
		{
			if(isset($item['visible']) && !$item['visible'])
				continue;

			$item2=array();
			$item2['label']=$item['label'];

			$item2['htmlOptions'] = isset($item['htmlOptions']) ? $item['htmlOptions'] : array();

			if($this->isActive($item['link']['url'],$action->id))
			{
				if(isset($item['htmlOptions']['class']))
					$item2['htmlOptions']['class'] .= ' active';
				else
					$item2['htmlOptions']['class'] = 'active';

			}

			$item2['a']['htmlOptions'] = array();
			$item2['a']['htmlOptions'] = $item['link']['htmlOptions'];


			if(isset($item['icon']))
			{
				$item2['icon']=$item['icon'];

				if(isset($item['htmlOptions']['class']))
					$item2['a']['htmlOptions']['class'] .= ' icon';
				else
					$item2['a']['htmlOptions']['class'] = 'icon';

			}

			$item2['icon'] = isset($item['icon']) ? $item['icon'] : null;
			$item2['a']['htmlOptions']['href'] = $item['link']['url'];

			$items[]=$item2;
		}

		$this->render('tabMenu',array('items'=>$items));
	}

	protected function isActive($url,$action)
	{
		preg_match('/'.$action.'$/i', $url, $res);
		return (bool)$res[0];
	}
}