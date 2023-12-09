CREATE TABLE `inventory` (
  `id_barang` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `email` char(50) NOT NULL,
  `gambar` varchar(250) NOT NULL
);

ALTER TABLE `inventory`
ADD PRIMARY KEY (`id_barang`);

ALTER TABLE `inventory`
MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;