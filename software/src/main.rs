#![no_std]
#![no_main]

use esp_backtrace as _;
use esp_hal::{
    clock::ClockControl, delay::Delay, gpio::IO, peripherals::Peripherals, system::SystemControl,
};

#[entry]
fn main() -> ! {
    let peripherals = Peripherals::take();
    let system = SystemControl::new(peripherals.SYSTEM);
    let clocks = ClockControl::boot_defaults(system.clock_control).freeze();

    let io = IO::new(peripherals.GPIO, &clocks);
    let mut led = io.pins.gpio2.into_push_pull_output();
    let mut delay = Delay::new(&clocks);

    loop {
        led.toggle();
        delay.delay_ms(1000);
    }
}
