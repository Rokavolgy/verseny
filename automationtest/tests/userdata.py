class UserData:
    def __init__(self, firstname, lastname, email, telephone, loginname, password, address_1, city, country_id,
                 postcode, zone_id):
        self.firstname = firstname
        self.lastname = lastname
        self.email = email
        self.telephone = telephone
        self.loginname = loginname
        self.password = password
        self.address_1 = address_1
        self.city = city
        self.country_id = country_id
        self.postcode = postcode
        self.zone_id = zone_id

    def __str__(self):
        return (
            f"{self.firstname}, {self.lastname}, {self.email}, {self.telephone}, {self.loginname}, {self.password}, "
            f"{self.address_1}, {self.city}, {self.country_id}, {self.postcode}, {self.zone_id}")
