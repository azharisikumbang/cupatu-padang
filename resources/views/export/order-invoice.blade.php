<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>A simple, clean, and responsive HTML invoice template</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<h4 style="color: rgb(0, 204, 204);">CUPATU PADANG</h4>
								</td>

								<td>
									<strong>Bukti Pemesanan #: {{ $order['id'] }}</strong><br />
									Tanggal: {{ date('d/m/Y H:i:s', strtotime($order['created_at'])) }}<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Cupatu Padang.<br />
									Kp. Olo, Kec. Naggalo, Padang 25137<br />
									<small><i>@cupatu_padang</i></small>
								</td>

								<td>
									To: {{ $order['customer_name'] }}<br />
									{{ $order['customer_contact'] }}<br />
									{{ $order['customer_address'] }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Metode Pembayaran</td>
                    <td></td>
				</tr>

				<tr class="details">
					<td><i>Dibayarkan Saat Pengembalian.</i></td>
				</tr>

				<tr class="heading">
					<td>Rincian Pemesanan</td>

					<td>Nominal </td>
				</tr>

                @foreach($order['details'] as $orderItem)

				<tr class="item">
					<td>
                        <span>Layanan {{ $orderItem['service_name'] }}</span>
                        <span>-</span>
                        <i style="color:gray">sepatu: {{ $orderItem['shoe_brand_name'] }}</i>
                    </td>

					<td>Rp. {{ number_format($orderItem['service_price'], 0, ',', '.') }}</td>
				</tr>

                @endforeach

				<tr class="item">
					<td>Ongkos Kirim</td>

					<td>Rp. {{ number_format($order['order_shipping_cost'], 0, ',', '.') }}</td>
				</tr>

				<tr class="total">
					<td></td>

					<td>Total: Rp. {{ number_format($order['order_price_total'], 0, ',', '.') }}</td>
				</tr>
			</table>
		</div>
	</body>
</html>