
	$( document ).ready(function() {
			requirejs.config({
				config: {
					moment: {
						noGlobal: true
					}
				},
				paths: {
					jquery: link+'assets/fuel/lib/jquery-1.9.1.min',
					underscore: 'http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min',
					bootstrap: link+'assets/fuel/lib/bootstrap/js',
					fuelux: link+'assets/fuel/src',
					moment: link+'assets/fuel/lib/moment', // comment out if you dont want momentjs to be default
					sample2: link+'assets/fuel/sample/datasource',
					sample3: link+'assets/fuel/sample/datasourceTree'
				}
			});
	
			require(['jquery', 'sample2', 'sample3', 'fuelux/all'], function ($, StaticDataSource, DataSourceTree) {
				
				$.ajax({
					type:'GET',
					url: link + "admin/products/get_all_products",
					cache:false,
					contentType: false,
					processData: false,
					dataType: 'json',
					success:function(data){
						// DATAGRID
						var dataSource = new StaticDataSource({
							columns: [
								{
									property: 'image',
									label: ' ',
									sortable: true
								},
								{
									property: 'code',
									label: 'Code',
									sortable: true
								},
								{
									property: 'brand',
									label: 'Brand',
									sortable: true
								},
								{
									property: 'name',
									label: 'Name',
									sortable: true
								},
								{
									property: 'selling',
									label: 'Selling Price',
									sortable: true
								},
								{
									property: 'buying',
									label: 'Buying Price',
									sortable: true
								},
								{
									property: 'balance',
									label: 'Balance',
									sortable: true
								},
								{
									property: 'offer_amount',
									label: 'Offer',
									sortable: true
								},
								{
									property: 'offer',
									label: 'On Offer',
									sortable: false
								},
								{
									property: 'view',
									label: ' ',
									sortable: false
								},
								{
									property: 'edit',
									label: ' ',
									sortable: false
								},
								{
									property: 'delete',
									label: ' ',
									sortable: false
								},
								{
									property: 'status',
									label: ' ',
									sortable: false
								},
								{
									property: 'recommend',
									label: ' ',
									sortable: false
								}
							],
							data: data.products,
							delay: 250
						});
			
						$('#MySelectStretchGrid').datagrid({
							dataSource: dataSource,
							stretchHeight: true,
							noDataFoundHTML: '<b>Sorry, nothing to display.</b>',
							enableSelect: true,
							primaryKey: 'product_id',
							multiSelect: true
						});
					},
					error: function(xhr, status, error) {
						alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
					}
				});
			});
	
	});