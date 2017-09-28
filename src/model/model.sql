-- triger a la supression d'un vehicule
DELIMITER //
CREATE TRIGGER vehicle_after_delete
BEFORE DELETE
   ON vehicles FOR EACH ROW
BEGIN
   	DELETE FROM offers
	WHERE offers.id_vehicle = old.idvehicle;
END //
DELIMITER ;
