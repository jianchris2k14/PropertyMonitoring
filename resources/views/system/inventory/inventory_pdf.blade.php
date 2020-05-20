@extends('layouts.pdf')

@section('web_title', 'Czarles | Stock Card')

@section('styles')

	<style type="text/css">
		table{
			width: 100%;
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>

@endsection

@section('content')

	<table>
		<thead>
			<tr>
				<th colspan="8">
					<center> Stock Card </center>
				</th>
			</tr>
			<tr>
				<th colspan="8" style="height: 15px;"></th>
			</tr>
			<tr>
				<th colspan="4" style="border-bottom: 1px solid black; text-align: left; font-size: 14px;">
					Item: {{ $inventory_item }}
				</th>
				<th colspan="4" style="border-bottom: 1px solid black; text-align: left; font-size: 14px;">
					Description: {{ $inventory_description }}
				</th>
			</tr>
			<tr>
				<th colspan="8" style="height: 15px; border-bottom: 1px solid black;"></th>
			</tr>
			<tr>
				<th style="border: 1px solid black;">DATE</th>
				<th style="border: 1px solid black;">Source/DR No.</th>
				<th style="border: 1px solid black;">IN</th>
				<th style="border: 1px solid black;">OUT</th>
				<th style="border: 1px solid black;">Balance</th>
				<th style="border: 1px solid black;">Purpose</th>
				<th style="border: 1px solid black;">Withdrawn By</th>
				<th style="border: 1px solid black;">Unit Location</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$size = count($inventory_stocks);
				for ($x = 0; $x < 30; $x++) {
					if($x < $size){
						echo '<tr>
							<td style="height: 18px; border: 1px solid black;">'. $inventory_stocks[$x]->inventory_stock_date .'</td>
							<td style="border: 1px solid black;">'. $inventory_stocks[$x]->inventory_stock_source .'</td>
							<td style="border: 1px solid black;">'. $inventory_stocks[$x]->inventory_stock_in .'</td>
							<td style="border: 1px solid black;">'. $inventory_stocks[$x]->inventory_stock_out .'</td>
							<td style="border: 1px solid black;"> </td>
							<td style="border: 1px solid black;">'. $inventory_stocks[$x]->inventory_stock_purpose .'</td>
							<td style="border: 1px solid black;">'. $inventory_stocks[$x]->inventory_stock_withdrawn_by .'</td>
							<td style="border: 1px solid black;">'. $inventory_stocks[$x]->inventory_stock_unit_location .'</td>
						</tr>';
					}else{
						echo '<tr>
							<td style="height: 18px; border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
						</tr>';
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8" style="height: 10px;"></td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Form No.:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">FM-PRO-CCS-RII-02</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Issue Status:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">02</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Revision No.:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">00</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Date Effective:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">30 June 2017</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Approved By:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">Proprietor/Gen. Manager</td>
			</tr>
			<tr>
				<td colspan="8" style="height: 10px;"></td>
			</tr>
		</tfoot>
	</table>

@endsection