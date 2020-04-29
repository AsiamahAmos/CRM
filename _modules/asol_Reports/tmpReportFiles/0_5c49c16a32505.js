
				try {

					var dataLabels_28c961c1c1d58b3b76095c49b9ef90ac_0 = [""];
					var chartObject = getNvd3DataJs({"chartType":"horizontal","chartYAxisLabel":"Website","indexKey":"28c961c1c1d58b3b76095c49b9ef90ac_0","colorPalete":[["#8c2b2b","#468c2b","#2b5d8c","#cd5200","#e6bf00","#7f3acd","#00a9b8","#572323","#004d00","#000087","#e48d30","#9fba09","#560066","#009f92","#b36262","#38795c","#3D3D99","#99623d","#998a3d","#994e78","#3d6899","#CC0000","#00CC00","#0000CC","#cc5200","#ccaa00","#6600cc","#005fcc"]],"chartLegends":[""],"chartValues":{"mainChart":[null]},"maxValue":0,"chartConfigs":{"mainConfig":[]}}, {"dataGroups":[{"Website":{"":null}}],"dataGroupsZ":null});var data_28c961c1c1d58b3b76095c49b9ef90ac_0 = [];data_28c961c1c1d58b3b76095c49b9ef90ac_0.push(chartObject);var asolColorPalete_28c961c1c1d58b3b76095c49b9ef90ac_0 = chartObject.values.map( a => a.color);
							
					nvReports.addGraph(function() {
							
						var chart_28c961c1c1d58b3b76095c49b9ef90ac_0 = nvReports.models.multiBarHorizontalChart().margin({top: 30, right: 30, bottom: 30, left: 80}).stacked(true).showValues(true).x(function(d) { return d.x }).y(function(d) { return d.y }).tooltips(true).showControls(true);
						
						
						chart_28c961c1c1d58b3b76095c49b9ef90ac_0.xAxis.rotateLabels(45).tickFormat(function(d) { return dataLabels_28c961c1c1d58b3b76095c49b9ef90ac_0[d]; });chart_28c961c1c1d58b3b76095c49b9ef90ac_0.yAxis.tickFormat(d3Reports.format(",.0f"));
						d3Reports.select("#ASOLnvd3_28c961c1c1d58b3b76095c49b9ef90ac_0 svg").datum(data_28c961c1c1d58b3b76095c49b9ef90ac_0).transition().duration(800).call(chart_28c961c1c1d58b3b76095c49b9ef90ac_0);nvReports.utils.windowResize(chart_28c961c1c1d58b3b76095c49b9ef90ac_0.update);return chart_28c961c1c1d58b3b76095c49b9ef90ac_0;
								
					});
								
					$("#ASOLnvd3Title_28c961c1c1d58b3b76095c49b9ef90ac_0").html("Reports<span style=\"font-weight: normal;\"></span>");
							
				} catch(e) {
					console.error(e);
				}