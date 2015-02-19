/*
 * jQuery Currency Converter Plugin
 * Version : 1.0
 * Plugin URL : https://valllabh.github.io/jquery.currency.converter
 * Author URL : http://vallabhjoshi.com
 * Author : Vallabh Joshi - copyright 2014
 * License : GPL Version 3
 * http://www.opensource.org/licenses/GPL-3.0
 */

(function($){

	$.fn.currency_converter = function( settings ){

		var self = this,
			settings = $.extend({
				base : 'USD',
				decimal : 0,
				target : '.price',
				currencies : {
					'USD' : { key : 'USD', rate : 1, format : '${value}', label : 'US Dollar' },
					'INR' : { key : 'INR', rate : 60, format : '{value} INR', label : 'Indian Rupee' }
				}
			}, settings);

		function getCurrency( id ){
			return settings.currencies[ id ] ? settings.currencies[ id ] : false;
		}

		function loadCurrencies( callback ){
			var load_currencies = [];

			for( c in settings.currencies ){
				var cur = getCurrency( c );
				load_currencies.push(settings.base+c);
			}
//http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.xchange where pair in ("USDEUR", "USDISK")&env=store://datatables.org/alltableswithkeys
			var jqxhr = $.ajax({
				url : 'http://query.yahooapis.com/v1/public/yql',
				dataType : 'jsonp',
				data : {
					q : 'select * from yahoo.finance.xchange where pair="'+ load_currencies.join(',') +'"',
					format : 'json',
					env : 'store://datatables.org/alltableswithkeys'
				}
			});

			jqxhr.done(function( data ){
				var curs = data.query.results.rate, i;
                                
				for( i in curs ){
					var cur = curs[i];
                                        console.log(cur);
					cur_k = cur.Name.substr( cur.Name.length - 3 );
					if( settings.currencies[ cur_k ] ){
						settings.currencies[ cur_k ].rate = cur.Rate;
					}
				}
				callback();
			}).fail(function( err ){
				callback();
			});
		}

		loadCurrencies(function(){
			self.each(function(){
				var $curreny_selector = $('<select></select>'), c;

				for( c in settings.currencies ){
					var cur = getCurrency( c ), $option;
					if( cur ){
						$option = $('<option></option>');
						$option.attr('value', c);
						$option.html(cur.label);
						$curreny_selector.append( $option );
					}
				}

				$curreny_selector.change(function(){
					updateTargetCurrency( $(this).find(':selected').val() );
				});

				$(this).append( $curreny_selector );
			});
		});

		function changeCurrency( value, to ){
			value = Number( ( $('<div>'+value+'</div>').text() ).replace(/[^0-9\.]+/g,"") );
			to = getCurrency( to );
			value = formatMoney( value * ( to.rate || 1 ) );
			return to.format.replace( '{value}', value );
		}

		function updateTargetCurrency( cur ){
			cur = getCurrency( cur );
			if( cur ){
				$.each($( settings.target ), function(){
					var $target = $(this), base_value;
					base_value = $target.data('base-value');
					if( !base_value ){
						$target.data('base-value', $(this).html() );
					}
					base_value = $target.data('base-value');
					$(this).html( changeCurrency( base_value, cur.key ) );
				});
			}
		}

		function formatMoney(n, d, t){
			c = isNaN(c = Math.abs(settings.decimal)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
			j = (j = i.length) > 3 ? j % 3 : 0;
			return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		};

		return this;
	}

})(jQuery)