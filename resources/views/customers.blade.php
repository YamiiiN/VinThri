<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
</head>
<body>
    <div>
        <h1>Manage Customers</h1>
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo $customer->customer_id; ?></td>
                        <td><?php echo $customer->first_name; ?></td>
                        <td><?php echo $customer->last_name; ?></td>
                        <td><?php echo $customer->email; ?></td>
                        <td><?php echo $customer->status; ?></td>
                        <td>
                            <form action="{{ route('admin.activateCustomer', $customer->customer_id) }}" method="POST">
                                @csrf
                                <button type="submit">
                                    <?php echo $customer->status == 'active' ? 'Deactivated' : 'Activate'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
