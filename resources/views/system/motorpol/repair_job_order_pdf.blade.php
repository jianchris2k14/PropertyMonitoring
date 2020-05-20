@extends('layouts.pdf')

@section('web_title', 'Czarles | Repair Job Order')

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
				<th colspan="4" style="height: 15px;"></th>
			</tr>
			<tr>
				<th colspan="4" style="text-align: center;">
					Repair Job Order
				</th>
			</tr>
			<tr>
				<th colspan="4" style="height: 15px;"></th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					Date Requested: {{ $repair_job_order->repair_job_order_date_requested }}
				</th>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					RJO No.: {{ $repair_job_order->repair_job_order_id }}
				</th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					Date Needed: {{ $repair_job_order->repair_job_order_date_needed }}
				</th>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					For Maintenance In-charge:
				</th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					Requestor's Name: {{ $repair_job_order->repair_job_order_requestors_name }}
				</th>
				<th colspan="2" style="text-align: left;font-size: 12px;padding-left: 50px;">
					Internal: {{ $repair_job_order->repair_job_order_for_maintenance_incharge_internal }}
				</th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					Date of Breakdown: {{ $repair_job_order->repair_job_order_date_breakdown }}
				</th>
				<th colspan="2" style="text-align: left;font-size: 12px;padding-left: 50px;">
					External (Outsourced): {{ $repair_job_order->repair_job_order_for_maintenance_incharge_external }}
				</th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					Equipment Name: 
				</th>
				<th colspan="2" style="text-align: left;font-size: 12px;">
					Model ID: 
				</th>
			</tr>
			<tr>
				<th colspan="4" style="height: 15px;"></th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;border: 1px solid black;">
					Diagnose Details
				</th>
				<th colspan="2" style="font-size: 12px;border: 1px solid black;width: 50%;">
					Repair Details
				</th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;border: 1px solid black;font-weight: normal;">
					Details of Breakdown
				</th>
				<th style="font-size: 12px;border: 1px solid black;font-weight: normal;">
					Action Taken
				</th>
				<th style="font-size: 12px;border: 1px solid black;font-weight: normal;">
					Repair Results
				</th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Mechanical:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Replace:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					OK
				</th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Electrical:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Resurface:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Not OK
				</th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Calibration:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Repair:
				</th>
				<th style="border: 1px solid black;"></th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Hydraulics:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Restore:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Repair Started:
				</th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Tinsmith:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Rebuild:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Repair Ended:
				</th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Welding:
				</th>
				<th style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Recondition:
				</th>
				<th style="border: 1px solid black;"></th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Painting:
				</th>
				<th style="border: 1px solid black;"></th>
				<th style="border: 1px solid black;"></th>
			</tr>
			<tr>
				<th colspan="2" style="font-size: 12px;text-align: left;border: 1px solid black;font-weight: normal;">
					Others:
				</th>
				<th style="border: 1px solid black;"></th>
				<th style="border: 1px solid black;"></th>
			</tr>
			<tr>
				<th colspan="4" style="height: 15px;"></th>
			</tr>
			<tr>
				<th style="border: 1px solid black;font-size: 11px;">
					PARTS NEEDED
				</th>
				<th style="border: 1px solid black;font-size: 11px;">
					QUANTITY
				</th>
				<th style="border: 1px solid black;font-size: 11px;">
					STOCKS AVAILABLE (WS NO.)
				</th>
				<th style="border: 1px solid black;font-size: 11px;">
					TO BE PURCHASED (RS NO.)
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$size = 0;
				for ($x = 0; $x < 15; $x++) {
					if($x < $size){
						// echo '<tr>
						// 	<td style="height: 18px; border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_date .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_source .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_in .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_out .'</td>
						// 	<td style="border: 1px solid black;"> </td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_purpose .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_withdrawn_by .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_unit_location .'</td>
						// </tr>';
					}else{
						echo '<tr>
							<td style="height: 18px; border: 1px solid black;"></td>
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
				<td colspan="4" style="height: 10px;"></td>
			</tr>
			<tr>
				<td style="font-size: 14px;">
					Reported By:
				</td>
				<td colspan="2" style="font-size: 14px;">
					Diagnosed By:
				</td>
				<td style="font-size: 14px;">
					Approved By:
				</td>
			</tr>
			<tr>
				<td style="font-size: 14px;">
					____________________
				</td>
				<td colspan="2" style="font-size: 14px;">
					____________________
				</td>
				<td style="font-size: 14px;">
					____________________
				</td>
			</tr>
			<tr>
				<td style="font-size: 14px;">
					Operators/Driver
				</td>
				<td colspan="2" style="font-size: 14px;">
					Mechanics/Maintenance In-charge
				</td>
				<td style="font-size: 14px;">
					Proprietor/General Manager
				</td>
			</tr>
			<tr>
				<td colspan="4" style="height: 20px;"></td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Form No.:</td>
				<td colspan="3" style="font-weight: bold;font-size: 10px;">FM-PRO-CCS-HOR-01</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Issue Status:</td>
				<td colspan="3" style="font-weight: bold;font-size: 10px;">02</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Revision No.:</td>
				<td colspan="3" style="font-weight: bold;font-size: 10px;">00</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Date Effective:</td>
				<td colspan="3" style="font-weight: bold;font-size: 10px;">30 June 2017</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Approved By:</td>
				<td colspan="3" style="font-weight: bold;font-size: 10px;">Proprietor/Gen. Manager</td>
			</tr>
		</tfoot>
	</table>

@endsection