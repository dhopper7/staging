<?php
require_once '../../../../jqSuitePHP_Sources_4_4_4_0/jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$categories = array(
	'0-4', '5-9', '10-14', '15-19',
	'20-24', '25-29', '30-34', '35-39', '40-44',
	'45-49', '50-54', '55-59', '60-64', '65-69',
	'70-74', '75-79', '80-84', '85-89', '90-94',
	'95-99', '100 +'
);

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"bar"
))
->setTitle(array('text'=>'Population pyramid for Germany, midyear 2010'))
->setSubtitle("text", "Source: www.census.gov")
->setxAxis(array(
	array("categories"=>$categories,"reversed"=> false),
	array("opposite"=>true, "reversed"=>false, "categories"=>$categories, "linkedTo"=> 0)
))
->setyAxis(array(
	"min"=>-4000000,
	"max"=>4000000,
	"title"=>array("text"=>null),
	"labels"=>array("formatter"=>"js:function(){return (Math.abs(this.value) / 1000000) + 'M';}")
))
->setLegend(array(
	"backgroundColor"=>'#FFFFFF',
	"reversed"=> true
))
->setTooltip(array(
	"formatter"=>"function(){return '<b>'+ this.series.name +', age '+ this.point.category +'</b><br/>'+'Population: '+ Highcharts.numberFormat(Math.abs(this.point.y), 0);}"
))
->setPlotOptions(array(
	"series"=> array(
		"stacking"=> 'normal'
	)
))
->addSeries('Male', array(
-1746181, -1884428, -2089758, -2222362, -2537431, -2507081, -2443179,
-2664537, -3556505, -3680231, -3143062, -2721122, -2229181, -2227768,
-2176300, -1329968, -836804, -354784, -90569, -28367, -3878))
->addSeries('Female', array(
1656154, 1787564, 1981671, 2108575, 2403438, 2366003, 2301402, 2519874,
3360596, 3493473, 3050775, 2759560, 2304444, 2426504, 2568938, 1785638,
1447162, 1005011, 330870, 130632, 21208));

echo $chart->renderChart('', true, 700, 350);

?>
