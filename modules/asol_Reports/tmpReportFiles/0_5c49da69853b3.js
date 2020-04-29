
				try {

					var dataLabels_3ade9e8d37be54bcd2145c49be1eb385_0 = [""];
					var chartObject = getNvd3DataJs({"chartType":"pie","chartYAxisLabel":"Opportunity Amount","indexKey":"3ade9e8d37be54bcd2145c49be1eb385_0","colorPalete":[["#8c2b2b","#468c2b","#2b5d8c","#cd5200","#e6bf00","#7f3acd","#00a9b8","#572323","#004d00","#000087","#e48d30","#9fba09","#560066","#009f92","#b36262","#38795c","#3D3D99","#99623d","#998a3d","#994e78","#3d6899","#CC0000","#00CC00","#0000CC","#cc5200","#ccaa00","#6600cc","#005fcc"]],"chartLegends":[""],"chartValues":{"mainChart":[null]},"maxValue":0,"chartConfigs":{"mainConfig":[]}}, null);var data_3ade9e8d37be54bcd2145c49be1eb385_0 = chartObject;var asolColorPalete_3ade9e8d37be54bcd2145c49be1eb385_0 = chartObject.map( a => a.color);
							
					nvReports.addGraph(function() {
							
						var chart_3ade9e8d37be54bcd2145c49be1eb385_0 = nvReports.models.pieChart().x(function(d) { return dataLabels_3ade9e8d37be54bcd2145c49be1eb385_0[d.key] }).y(function(d) { return d.y }).values(function(d) { return d }).tooltips(true).color(d3Reports.scale.ordinal().range(asolColorPalete_3ade9e8d37be54bcd2145c49be1eb385_0).range()).pieLabelsOutside(true).donut(false)
						.valueFormat(function(d) { return (d3Reports.format(",.0f")(d)) });
						
						
						d3Reports.select("#ASOLnvd3_3ade9e8d37be54bcd2145c49be1eb385_0 svg").datum(data_3ade9e8d37be54bcd2145c49be1eb385_0).transition().duration(800).call(chart_3ade9e8d37be54bcd2145c49be1eb385_0);nvReports.utils.windowResize(chart_3ade9e8d37be54bcd2145c49be1eb385_0.update);return chart_3ade9e8d37be54bcd2145c49be1eb385_0;
								
					});
								
					$("#ASOLnvd3Title_3ade9e8d37be54bcd2145c49be1eb385_0").html("Sales<span style=\"font-weight: normal;\"></span>");
							
				} catch(e) {
					console.error(e);
				}