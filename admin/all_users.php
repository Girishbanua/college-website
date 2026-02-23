  <div class="card">
      <h3>👥 Users</h3>
      <table>
          <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
          </tr>
          <?php while ($u = mysqli_fetch_assoc($users)) { ?>
              <tr>
                  <td><?= htmlspecialchars($u['name']) ?></td>
                  <td><?= htmlspecialchars($u['email']) ?></td>
                  <td><?= htmlspecialchars($u['role']) ?></td>
                  <td>
                      <a class="btn danger" href="delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
                  </td>
              </tr>
          <?php } ?>
      </table>
  </div>