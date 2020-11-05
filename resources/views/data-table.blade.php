<div class="relative bg-white mt-8">
	<div class="relative max-w-7xl mx-auto">
		<table class="table-auto w-full ml-5 text-sm mb-8">
			<tr class=" table-row border rounded text-left">
				<th class="px-4 py-2">
					Name
				</th>
				<th class="px-4 py-2">Email</th>
				<th class="px-4 py-2">Status</th>
				<th class="px-4 py-2">Register date</th>
			</tr>
			@foreach ($users as $user)
				<tr class="border">
					<td class="px-4 py-2">{{ $user->name }}</td>
					<td class="px-4 py-2">{{ $user->email }}</td>
					<td class="px-4 py-2">
						<span class="rounded-full {{ $user->active ? 'bg-green-200' : 'bg-red-200' }} px-2 text-sm">
							{{ $user->active ? 'active' : 'inactive' }}
						</span>
					</td>
					<td class="px-4 py-2">{{ date_format($user->created_at, 'd.m.Y') }}</td>
				</tr>
			@endforeach
		</table>
		{{ $users->links() }}
	</div>
</div>